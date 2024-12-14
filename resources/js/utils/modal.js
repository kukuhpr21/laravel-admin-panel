const modalConfirm = document.getElementById('hs-modal-confirm');

const showModalConfirm = (title, body, actionText, link) => {
    // set text
    $('#hs-modal-confirm-title').text(title)
    $('#hs-modal-confirm-body').text(body)
    $('#hs-modal-confirm-close').text('Close')
    $('#hs-modal-confirm-action').text(actionText)

    $('#hs-modal-confirm-action').on("click", (event) => {
        window.location.replace(link);
    })

    window.HSOverlay.open(modalConfirm)
}

const closeModalConfirm = () => {
    window.HSOverlay.close(modalConfirm)
}



const modal = {
    showModalConfirm,
    closeModalConfirm,
}

export default modal;
