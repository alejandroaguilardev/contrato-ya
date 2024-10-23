import envs from "@/config/envs";

const form = document.getElementById("newsletter-form") as HTMLFormElement;
const alertElement = document.getElementById("newsletter-alert") as HTMLElement;

form?.addEventListener("submit", handleSubmit);

function handleSubmit(event: Event): void {
    event.preventDefault();

    if (!isTermsChecked()) {
        showAlert("Debes aceptar los términos y condiciones.", "error");
        return;
    }

    grecaptcha.execute(envs.PUBLIC_GOOGLE_PUBLIC_KEY, { action: "submit" })
        .then((token) => {
            const email = getEmail();
            subscribe(email, token)
                .then(handleSuccess)
                .catch(handleError)
                .finally(resetForm);
        }).catch(handleError);
}


async function subscribe(email: string, recaptchaToken: string): Promise<void> {
    const response = await fetch(envs.PUBLIC_HOST_API + "/api/brevo/subscribe", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, recaptcha: recaptchaToken }),
    });

    if (!response.ok) throw new Error("Error en la suscripción");
}


function isTermsChecked(): boolean {
    const termsCheckbox = form.elements.namedItem("terms") as HTMLInputElement;
    return termsCheckbox.checked;
}

function getEmail(): string {
    const emailInput = form.elements.namedItem("email") as HTMLInputElement;
    return emailInput.value;
}


function handleSuccess(): void {
    showAlert("¡Te has suscrito correctamente!", "success");
    form.style.display = "none";
}

function handleError(error: Error): void {
    showAlert(`Error al suscribirse: ${error.message}`, "error");
}

function showAlert(message: string, type: string): void {
    alertElement.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
}

function resetForm(): void {
    form.reset();
    grecaptcha.reset();
}
