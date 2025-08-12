document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("contactForm")
    const progressFill = document.getElementById("progressFill")
    const charCount = document.getElementById("charCount")
    const contentTextarea = document.getElementById("content")
    const submitBtn = document.getElementById("submitBtn")
    const buttonText = document.getElementById("buttonText")

    // Contador de caracteres
    if (contentTextarea && charCount) {
        function updateCharCount() {
            const count = contentTextarea.value.length
            charCount.textContent = count
            charCount.style.color = count > 800 ? "#fca5a5" : "rgba(255,255,255,0.6)"
        }
        contentTextarea.addEventListener("input", updateCharCount)
        updateCharCount()
    }

    // Barra de progresso
    function updateProgress() {
        const inputs = form.querySelectorAll("input[required], textarea[required]")
        const filledInputs = Array.from(inputs).filter(i => i.value.trim() !== '').length
        progressFill.style.width = (filledInputs / inputs.length) * 100 + "%"
    }

    // Atualiza progresso em tempo real
    form.addEventListener("input", updateProgress)
    updateProgress()

    // Remove classe de erro ao digitar
    document.querySelectorAll(".input-error").forEach(input => {
        input.addEventListener("input", () => {
            input.classList.remove("input-error")
            const errorMsg = input.parentNode.querySelector(".field-error")
            if (errorMsg) errorMsg.style.display = "none"
        })
    })

    // Submissão do formulário
    form.addEventListener("submit", () => {
        if (submitBtn && buttonText) {
            submitBtn.disabled = true
            buttonText.innerHTML = '<div class="loading"><div class="spinner"></div>Enviando...</div>'
        }
    })

    // Mensagens desaparecem depois de 5s
    document.querySelectorAll(".success-message, .error-message").forEach(message => {
        setTimeout(() => {
            message.style.opacity = "0"
            setTimeout(() => { message.style.display = "none" }, 300)
        }, 5000)
    })
})
