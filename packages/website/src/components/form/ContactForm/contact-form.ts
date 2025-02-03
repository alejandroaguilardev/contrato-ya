import envs from "@/config/envs";

const form = document.getElementById("contact-form") as HTMLFormElement;
const alertElement = document.getElementById("contact-alert") as HTMLElement;
const contactElement = document.getElementById("contact-button") as HTMLButtonElement;

form?.addEventListener("submit", handleSubmit);

function handleSubmit(event: Event): void {
    event.preventDefault();

    if (!isTermsChecked()) {
        showAlert("Debes aceptar los términos y condiciones.", "error");
        return;
    }

    grecaptcha.execute(envs.GOOGLE_RECAPTCHA, { action: "submit" })
        .then((token) => {
            if (contactElement) {
                contactElement.disabled = true;
            }
            const data = getData();
            sendContact(data, token)
                .then(handleSuccess)
                .catch(handleError)
                .finally(resetForm);
        }).catch(handleError);
}


async function sendContact(data: {
    name: string;
    email: string;
    phone: string;
    message: string;
}, recaptchaToken: string): Promise<void> {
    const response = await fetch(envs.HOST_API_MAIL + "/api/mail/send", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ...data, recaptcha: recaptchaToken }),
    });

    if (!response.ok) throw new Error("Error al enviar el email, intenta nuevamente");
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
    showAlert("Se ha enviado el correo exitosamente!", "success");
    form.style.display = "none";
}

function handleError(error: Error): void {
    showAlert(`Error al suscribirse: ${error.message}`, "error");
    contactElement.disabled = false;

}

function showAlert(message: string, type: string): void {
    alertElement.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
}

function resetForm(): void {
    form.reset();
    grecaptcha.reset();
}
