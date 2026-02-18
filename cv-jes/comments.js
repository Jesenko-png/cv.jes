document.addEventListener("DOMContentLoaded", () => {
	const form = document.getElementById("commentForm");

	const modal = document.getElementById("modal");
	const modalTitle = document.getElementById("modalTitle");
	const modalText = document.getElementById("modalText");
	const modalClose = document.getElementById("modalClose");
	const modalOk = document.getElementById("modalOk");

	if (!form || !modal) return;

	function openModal(title, text) {
		modalTitle.textContent = title;
		modalText.textContent = text;
		modal.classList.add("active");
	}

	function closeModal() {
		modal.classList.remove("active");
	}

	modalClose.addEventListener("click", closeModal);
	modalOk.addEventListener("click", closeModal);
	modal.addEventListener("click", (e) => {
		if (e.target === modal) closeModal();
	});

	form.addEventListener("submit", async (e) => {
		e.preventDefault();

		try {
			const res = await fetch("comment.php", {
				method: "POST",
				body: new FormData(form),
			});

			const data = await res.json();

			if (data.ok) {
				openModal("Erfolg 🎉", data.message);
				form.reset();
			} else {
				openModal("Fehler ❌", data.message);
			}
		} catch (err) {
			openModal("Serverfehler", "Bitte später erneut versuchen.");
		}
	});
});
