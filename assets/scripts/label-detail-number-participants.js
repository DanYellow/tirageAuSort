const participantsStatusLabel = document.querySelector(
    "[data-participants-status]"
);

if (participantsStatusLabel) {
    participantsStatusLabel.dataset.participantsStatus =
        participantsStatusLabel.textContent;

    const enableParticipantObserver = new MutationObserver((mutationList) => {
        mutationList.forEach((mutation) => {
            if (mutation.type === "attributes") {
                const nbActiveParticipants = document.querySelectorAll(
                    "[data-take-part] input[type='radio'][value='1']:checked"
                ).length;
                const nbParticipants =
                    document.querySelectorAll(
                        "[data-take-part] input[type='radio']"
                    ).length / 2;

                participantsStatusLabel.textContent = `
                ${participantsStatusLabel.dataset.participantsStatus} (${nbActiveParticipants}/${nbParticipants})
            `;
            }
        });
    });

    document.querySelectorAll(".accordion-button").forEach((item) => {
        enableParticipantObserver.observe(item, {
            attributes: true,
        });
    });
}
