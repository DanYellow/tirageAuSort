const participantsStatusLabel = document.querySelector(
    "[data-participants-status]"
);

if (participantsStatusLabel) {
    participantsStatusLabel.dataset.participantsStatus =
        participantsStatusLabel.textContent;

    const updateParticipantsIndicator = () => {
        const nbActiveParticipants = document.querySelectorAll(
            "[data-take-part] input[type='radio'][value='1']:checked"
        ).length;
        const nbParticipants =
            document.querySelectorAll("[data-take-part] input[type='radio']")
                .length / 2;

        participantsStatusLabel.textContent = `
            ${participantsStatusLabel.dataset.participantsStatus} (${nbActiveParticipants}/${nbParticipants})
        `;
    };

    updateParticipantsIndicator();

    const toggleNbParticipants = new MutationObserver((mutationList) => {
        mutationList.forEach((mutation) => {
            switch (mutation.type) {
                case "childList":
                case "attributes":
                    updateParticipantsIndicator();
                    break;
            }
        });
    });

    toggleNbParticipants.observe(
        document.querySelector(".ea-form-collection-items"),
        {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ["class", "value"],
        }
    );
}
