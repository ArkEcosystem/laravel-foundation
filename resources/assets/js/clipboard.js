window.clipboard = () => {
    return {
        copying: false,
        notSupported: false,

        copy(value) {
            this.copying = true;

            const clipboard = window.navigator.clipboard;

            if (clipboard && window.isSecureContext) {
                clipboard.writeText(value).then(
                    () => (this.copying = false),
                    () => {
                        this.copying = false;

                        console.error(
                            "Failed to copy contents to the clipboard."
                        );
                    }
                );

                return;
            }

            console.warn(
                "Copying to clipboard requires an HTTPS connection on some browsers and may cause unexpected issues."
            );

            // Expect most browsers to have the Navigator and support for clipboard...
            // But use deprecated execCommand as a last resort...
            this.copyUsingExec(value);
        },

        copyUsingExec(value) {
            const textArea = document.createElement("textarea");

            textArea.value = value;

            // Prevent keyboard from showing on mobile
            textArea.setAttribute("readonly", "");

            // fontSize prevents zooming on iOS
            textArea.style.cssText =
                "position:absolute;top:0;left:0;z-index:-9999;opacity:0;fontSize:12pt;";

            document.body.append(textArea);

            const isiOSDevice = navigator.userAgent.match(/ipad|iphone/i);

            if (isiOSDevice) {
                const editable = textArea.contentEditable;
                const readOnly = textArea.readOnly;

                textArea.contentEditable = "true";
                textArea.readOnly = false;

                const range = document.createRange();
                range.selectNodeContents(textArea);

                const selection = window.getSelection();

                if (selection) {
                    selection.removeAllRanges();
                    selection.addRange(range);
                }

                textArea.setSelectionRange(0, 999999);
                textArea.contentEditable = editable;
                textArea.readOnly = readOnly;
            } else {
                textArea.select();
                textArea.focus();
            }

            this.copying = true;
            setTimeout(() => (this.copying = false), 1200);

            document.execCommand("copy");

            textArea.remove();
        },

        copyFromInput(identifier) {
            const element = document.querySelector(identifier);

            this.copy(element.value);
        },
    };
};
