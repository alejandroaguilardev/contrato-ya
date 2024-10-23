<?php

namespace App\Subscribe\Infrastructure;

use App\Common\Infrastructure\CurlHttpClient;
use App\Common\Infrastructure\GoogleRecaptcha;
use App\Subscribe\Application\SubscriptionContact;
use App\Subscribe\Infrastructure\Validators\SubscriptionRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubscribeController extends AbstractController
{
    public function __construct(
        readonly CurlHttpClient $curlHttpClient,
        readonly SubscriptionRequestValidator $requestValidator,
        readonly SubscriptionContact $subscriptionContact,
        readonly GoogleRecaptcha $googleRecaptcha
    ) { }

    public function subscribe(Request $request): JsonResponse
    {
        try {
            $this->getRecaptchaToken($request);
            $email = $this->requestValidator->validate($request);
            $message = $this->subscriptionContact->subscribe($email);
            return new JsonResponse(['message' => $message], Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => "Error en la suscripción: " . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
