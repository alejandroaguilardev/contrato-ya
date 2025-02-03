<?php

namespace App\SendMailContact\Infrastructure;

use App\Common\Infrastructure\GoogleRecaptcha;
use App\Common\Infrastructure\MailerMailService;
use App\SendMailContact\Application\SendMailContact;
use App\SendMailContact\Infrastructure\Validators\ContactRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class SendMailContactController extends AbstractController
{
    public function __construct(
        readonly ContactRequestValidator $requestValidator,
        readonly SendMailContact $sendMailContact,
        readonly GoogleRecaptcha $googleRecaptcha,
        readonly MailerMailService $mailerMailService
    ) { }

    public function sendMail(Request $request): JsonResponse
    {
        try {
            $this->getRecaptchaToken($request);
            $contact = $this->requestValidator->validate($request);
            $message = $this->sendMailContact->sendMail($contact);
            return new JsonResponse(['message' => $message], Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => "Error en enviar el correo: " . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    private function getRecaptchaToken (Request $request) {
        $data = json_decode($request->getContent(), true);
        $recaptchaToken = $data["recaptcha"];
        if (!$recaptchaToken) {
            return new JsonResponse(['error' => 'reCAPTCHA token is missing.'], Response::HTTP_BAD_REQUEST);
        }
        
        if (!$this->googleRecaptcha->validateRecaptcha($recaptchaToken)) {
            return new JsonResponse(['error' => 'reCAPTCHA validation failed.'], Response::HTTP_BAD_REQUEST);
        }
    }
}
