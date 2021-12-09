const handleFetchSuccessResponse = (response) => {
    const { status } = response;
    if (status === 200) {
        return response.json();
        // Means the CSRF Token is no longer valid
    } else if (status === 419) {
        alert(
            "Session expired. You will need to refresh the browser to continue uploading images."
        );
    } else {
        throw new Error(response);
    }
};

const handleFetchErrorResponse = (error) => {
    if (error.name === "AbortError") {
        return;
    }

    alert("Something went wrong!");
    console.error(error);
};

export const uploadImage = (blob, csrfToken) => {
    const formData = new FormData();
    formData.append("image", blob);

    return fetch(`/wysiwyg/upload-image`, {
        method: "POST",
        body: formData,
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        .then((response) => handleFetchSuccessResponse(response))
        .catch((error) => handleFetchErrorResponse(error));
};

export const getWordsAndCharactersCount = (
    markdown,
    csrfToken,
    cancelSignal
) => {
    const formData = new FormData();
    formData.append("markdown", markdown);

    return fetch(`/wysiwyg/count-characters`, {
        method: "POST",
        body: formData,
        signal: cancelSignal,
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        .then((response) => handleFetchSuccessResponse(response))
        .catch((error) => handleFetchErrorResponse(error));
};

export const initModalhandler = (editor, modalName, getReplacement) => {
    Livewire.on(modalName, (e) => {
        const form = e.target;
        const formData = new FormData(form);
        const replacement = getReplacement(formData);

        const currentSelection = editor.getSelection();

        editor.replaceSelection(replacement);

        Livewire.emit("closeModal", modalName);

        form.reset();

        setTimeout(() => {
            document.querySelector(".ProseMirror").focus();

            editor.setSelection(
                [currentSelection[0][0], currentSelection[0][1]],
                [
                    currentSelection[0][0],
                    currentSelection[0][1] + replacement.length,
                ]
            );
        }, 500);
    });
};
