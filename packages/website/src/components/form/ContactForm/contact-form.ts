import envs from "@/config/envs";

const form = document.getElementById("contact-form") as HTMLFormElement;
const alertElement = document.getElementById("alert") as HTMLElement;

form?.addEventListener("submit", handleSubmit);

function handleSubmit(event: Event): void {
    event.preventDefault();

    if (!isTermsChecked()) {
        showAlert("Debes aceptar los términos y condiciones.", "error");
        return;
    }

    grecaptcha.execute(envs.PUBLIC_GOOGLE_PUBLIC_KEY, { action: "submit" })
        .then((token) => {
            sendMail(token)
                .then(handleSuccess)
                .catch(handleError)
                .finally(resetForm);
        }).catch(handleError);
}


async function sendMail(recaptchaToken: string): Promise<void> {
    const data = getData();
    const response = await fetch(envs.PUBLIC_HOST_API + "/api/brevo/sendemail/contact", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ...data, recaptcha: recaptchaToken }),
    });

    if (!response.ok) throw new Error("Error al enviar mail");
}


function isTermsChecked(): boolean {
    const termsCheckbox = form.elements.namedItem("terms") as HTMLInputElement;
    return termsCheckbox.checked;
}


function getData(): { name: string; email: string; phone: string; message: string } {
    const name = form.elements.namedItem("name") as HTMLInputElement;
    const email = form.elements.namedItem("email") as HTMLInputElement;
    const phone = form.elements.namedItem("phone") as HTMLInputElement;
    const message = form.elements.namedItem("message") as HTMLTextAreaElement;

    return {
        name: name.value,
        email: email.value,
        phone: phone.value,
        message: message.value,
    };
}

function handleSuccess(): void {
    showAlert("¡Has enviado el correo correctamente!", "success");
}

function handleError(error: Error): void {
    showAlert(`Error al enviar mail: ${error.message}`, "error");
}

function showAlert(message: string, type: string): void {
    alertElement.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
}

function resetForm(): void {
    form.reset();
    grecaptcha.reset();
}
