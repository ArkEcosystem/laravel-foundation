import Editor from "@toast-ui/editor";

import underlinePlugin from "./plugins/underline.js";

import {
    getWordsAndCharactersCount,
    // uploadImage,
    initModalhandler,
} from "./utils/utils.js";

const AVERAGE_WORDS_READ_PER_MINUTE = 200;

// Based on: https://github.com/nhn/tui.editor/blob/16e0b88ba2cac0631ffdf8777a22bb696380d2fb/apps/editor/src/markdown/helper/list.ts#L62
const reList = /(^\s*)([-*+])/;
const reOrderedList = /(^\s*)([\d])+\.( \[[ xX]])? /;

const MarkdownEditor = (
    name,
    height = null,
    charsLimit = "0",
    extraData = {}
) => ({
    name: name,
    editor: null,
    charsLimit: parseInt(charsLimit),
    charsCount: 0,
    wordsCount: 0,
    readMinutes: 0,
    height: height || "600px",
    loadingCharsCount: false,
    loadingCharsTimeout: false,
    loadingCharsAbortController: null,
    showMobileMenu: false,
    undo() {
        this.editor.mdEditor.commands.undo();
    },
    redo() {
        this.editor.mdEditor.commands.redo();
    },
    heading(level) {
        this.editor.mdEditor.commands.heading({ level });
    },
    strong() {
        this.editor.mdEditor.commands.bold();
    },
    emph() {
        this.editor.mdEditor.commands.italic();
    },
    strike() {
        this.editor.mdEditor.commands.strike();
    },
    underline() {
        this.editor.mdEditor.commands.underline();
    },
    blockQuote() {
        this.editor.mdEditor.commands.blockQuote();
    },
    bulletList() {
        this.editor.mdEditor.commands.bulletList();
    },
    orderedList() {
        this.editor.mdEditor.commands.orderedList();
    },
    orderedList() {
        this.editor.mdEditor.commands.orderedList();
    },
    code() {
        this.editor.mdEditor.commands.code();
    },
    codeBlock() {
        this.editor.mdEditor.commands.codeBlock();
    },
    table() {
        this.editor.eventEmitter.emit("openPopup", "table", {});
    },
    image() {
        this.openModal("imageModal");
    },
    link() {
        this.openModal("linkModal");
    },
    embedLink() {
        this.openModal("embedLinkModal");
    },
    embedTweet() {
        this.openModal("embedTweetModal");
    },
    embedPodcast() {
        this.openModal("embedPodcastModal");
    },
    linkCollection() {
        this.openModal("linkCollectionModal");
    },
    alertModal() {
        this.openModal("alertModal");
    },
    pageReference() {
        this.openModal("pageReferenceModal");
    },
    toggleMobileMenu() {
        this.showMobileMenu = !this.showMobileMenu;
    },
    activeButtons: [],
    isActive(name) {
        return this.activeButtons.includes(name);
    },
    init() {
        try {
            const { editor: el, input } = this.$refs;

            this.editor = new Editor({
                el,
                usageStatistics: false,
                initialEditType: "markdown",
                previewStyle: "tab",
                previewHighlight: false,
                hideModeSwitch: true,
                initialValue: input.value,
                height: this.height,
                events: {
                    change: () => this.onChangeHandler(),
                    caretChange: () => this.onCaretChangeHandler(),
                    blur: this.onBlur,
                    focus: this.onFocus,
                },
                plugins: [underlinePlugin(this.name)],
                // We dont need any "sanitized" HTML since we dont use the `preview`
                // mode, so doing this:
                // 1. Prevents security issues
                // 2. Makes the editor way faster
                customHTMLSanitizer: () => "",
                // The following hook is not currently used since I added a new modal for handling the image.
                // That modal doesn't have the file upload logic implemented yet but is very likely that we can
                // reuse most of the logic here so I am going to leave the code here for future reference.
                // hooks: {
                //     addImageBlobHook: (blob, callback) => {
                //         const alt =
                //             document.querySelector("#toastuiAltTextInput")
                //                 .value || blob.name;
                //         // const markdownEditor = this.editor.mdEditor.getEditor();
                //         const loadingLabel = `Uploading ${blob.name}…`;

                //         const loadingPlaceholder = `![${loadingLabel}]()`;

                //         const csrfToken = document.querySelector(
                //             'meta[name="csrf-token"]'
                //         ).content;

                //         if (!csrfToken) {
                //             throw new Error(
                //                 "We were unable to get the csrfToken for this request"
                //             );
                //         }

                //         // Show a loading message while the image is uploaded
                //         callback("", loadingLabel);

                //         const placeholderSelection = this.editor.getSelection();

                //         uploadImage(blob, csrfToken).then((response) => {
                //             if (!response.url) {
                //                 throw new Error("Received invalid response");
                //             }

                //             // Select the placeholder again in case user unselected it.
                //             // It will be replaced in the following callback
                //             this.editor.setSelection(
                //                 [
                //                     placeholderSelection[1][0],
                //                     placeholderSelection[1][1] -
                //                         loadingPlaceholder.length -
                //                         2,
                //                 ],
                //                 [
                //                     placeholderSelection[1][0],
                //                     placeholderSelection[1][1],
                //                 ]
                //             );

                //             callback(response.url, alt);
                //         });

                //         return true;
                //     },
                // },
            });

            // Disables the scroll sync used on the preview since we dont use it
            // and it throws some expections
            this.editor.scrollSync.active = false;

            this.getWordsAndCharactersCount(this.editor.getMarkdown());

            this.initModals();

            this.adjustNavbar();

            window.onresize = () => {
                this.adjustNavbar();
            };
        } catch (error) {
            alert("Something went wrong!");
            console.error(error);
        }
    },
    openModal(modelName) {
        Livewire.emit("openModal", modelName);
    },
    initModals() {
        initModalhandler(this.editor, "imageModal", (formData) => {
            const image = formData.get("image");
            const description = formData.get("description");

            return `![${description || image}](${image})`;
        });

        initModalhandler(this.editor, "linkModal", (formData) => {
            const url = formData.get("url");
            const text = formData.get("text");

            return `[${text || url}](${url})`;
        });

        initModalhandler(this.editor, "embedTweetModal", (formData) => {
            const urlOrCode = formData.get("url");

            const tweetId = urlOrCode.startsWith("https://twitter.com")
                ? urlOrCode.split("https://twitter.com/")[1]
                : urlOrCode;

            return `![](twitter:${tweetId})`;
        });

        initModalhandler(this.editor, "embedPodcastModal", (formData) => {
            const urlOrCode = formData.get("url");

            const regExp = /^.*simplecast.com\/(\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b)/;
            const match = urlOrCode.match(regExp);
            const simpleCastId =
                match && match.length === 2 ? match[1] : urlOrCode;

            return `![](simplecast:${simpleCastId})`;
        });

        initModalhandler(this.editor, "linkCollectionModal", (formData) => {
            const names = formData
                .getAll("name")
                .filter((name) => name.length > 0);
            const paths = formData
                .getAll("path")
                .filter((name) => name.length > 0);

            const links = names.map((name, index) => {
                return `[${name}](${paths[index]})`;
            });

            return `<x-link-collection\n\tlinks="[\n\t\t${links.join(
                ",\n\t\t"
            )},\n\t]"\n/>`;
        });

        initModalhandler(this.editor, "alertModal", (formData) => {
            const type = formData.get("type");
            const text = formData.get("text");

            return `<x-alert type="${type}">${text}</x-alert>`;
        });

        initModalhandler(this.editor, "pageReferenceModal", (formData) => {
            const url = formData.get("url");

            return `<livewire:page-reference page="${url}" />`;
        });
    },
    // @TODO: add this logic to the custom link modal
    forceHttpsLinkHandler: (event, data) => {
        if (event === "AddLink") {
            if (/^\/\//.test(data.url)) {
                data.url = "https:" + data.url;
                return data;
            }

            if (/^\//.test(data.url)) {
                return data;
            }

            if (!/^https?:\/\//.test(data.url)) {
                data.url = "https://" + data.url;
                return data;
            }
        }

        return data;
    },
    onChangeHandler() {
        const { input } = this.$refs;

        const markdown = this.editor.getMarkdown();

        input.value = markdown;

        const event = new Event("input", {
            bubbles: true,
            cancelable: true,
        });

        input.dispatchEvent(event);

        this.getWordsAndCharactersCount(markdown);
    },
    onCaretChangeHandler() {
        this.activeButtons = [
            "strong",
            "heading1",
            "heading2",
            "heading3",
            "heading4",
            "emph",
            "strike",
            "blockQuote",
            "bulletList",
            "orderedList",
            "table",
            "link",
            "code",
            "codeBlock",
        ].filter((name) => {
            const selection = this.editor?.mdEditor.view.state.selection || {};
            const { $from, $to } = selection;

            if (["bulletList", "orderedList"].includes(name)) {
                const endIndex = $to?.index(0);
                let textContent = ";";

                try {
                    textContent = $from?.doc.child(endIndex)?.textContent || "";
                } catch (e) {}

                if (name === "bulletList") {
                    return reList.test(textContent);
                }

                if (name === "orderedList") {
                    return reOrderedList.test(textContent);
                }
            }

            const fromMarks = $from?.marks() || [];
            const toMarks = $to?.marks() || [];

            if (name.startsWith("heading")) {
                const headingLevel = Number(name.replace("heading", ""));

                return (
                    fromMarks.some(
                        (mark) =>
                            mark.type.name === "heading" &&
                            mark.attrs.level === headingLevel
                    ) ||
                    toMarks.some(
                        (mark) =>
                            mark.type.name === "heading" &&
                            mark.attrs.level === headingLevel
                    )
                );
            }

            if (name === "table") {
                return (
                    fromMarks.some(
                        (mark) =>
                            mark.type.name === name ||
                            mark.type.name === "tableCell"
                    ) ||
                    toMarks.some(
                        (mark) =>
                            mark.type.name === name ||
                            mark.type.name === "tableCell"
                    )
                );
            }

            return (
                fromMarks.some((mark) => mark.type.name === name) ||
                toMarks.some((mark) => mark.type.name === name)
            );
        });
    },
    getWordsAndCharactersCount(markdown) {
        this.loadingCharsCount = true;

        // Throttles the call to get the word count to avoid multiple requests
        // while the user is typing.
        if (this.loadingCharsTimeout) {
            clearTimeout(this.loadingCharsTimeout);
            this.loadingCharsTimeout = null;
        }

        this.loadingCharsTimeout = setTimeout(async () => {
            this.loadingCharsTimeout = null;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                .content;

            // The following lines cancels any pending request in favour
            // of the incoming one.
            if (this.loadingCharsCount && this.loadingCharsAbortController) {
                this.loadingCharsAbortController.abort();
            }
            this.loadingCharsAbortController = new AbortController();

            try {
                const { characters, words } = await getWordsAndCharactersCount(
                    markdown,
                    csrfToken,
                    this.loadingCharsAbortController.signal
                );

                this.charsCount = characters;
                this.wordsCount = words;
                this.readMinutes = Math.round(
                    this.wordsCount / AVERAGE_WORDS_READ_PER_MINUTE
                );
            } catch (e) {}

            this.loadingCharsCount = false;
        }, 500);
    },
    adjustNavbar() {
        this.showMobileMenu = false;

        const scroll = document.querySelector(
            ".ark-markdown-editor-toolbar:not(.ark-markdown-editor-toolbar-mobile) > div"
        );
        const mobile = document.querySelector(
            ".ark-markdown-editor-toolbar-mobile > div"
        );
        const items = Array.from(
            scroll.querySelectorAll(".markdown-navbar-item")
        );
        const mobileItems = Array.from(
            mobile.querySelectorAll(".markdown-navbar-item")
        );
        const moreButton = scroll.querySelector(".markdown-navbar-more");

        // Reset display of all items
        items.forEach((item) => {
            item.style.display = null;
        });
        mobileItems.forEach((item) => {
            item.style.display = "none";
        });

        const hiddenIndex = [];

        // Hide from the last item until the scroll dissapears
        for (var i = items.length - 1; i >= 0; i--) {
            const isScrolled = scroll.scrollWidth > scroll.clientWidth;

            if (!isScrolled) {
                break;
            }

            items[i].style.display = "none";
            hiddenIndex.push(i);
        }

        if (hiddenIndex.length > 0) {
            // Show the more button if there are hidden items
            moreButton.style.display = null;

            // With the moreButton visible the scroll may appear again
            const isScrolled = scroll.scrollWidth > scroll.clientWidth;
            if (isScrolled) {
                // After the more button is shown, maybe we need to hide an extra item
                const nextItemToHideIndex =
                    hiddenIndex[hiddenIndex.length - 1] - 1;
                if (nextItemToHideIndex >= 0) {
                    console.log(items[nextItemToHideIndex]);
                    items[nextItemToHideIndex].style.display = "none";
                    hiddenIndex.push(nextItemToHideIndex);
                }
            }
        } else {
            moreButton.style.display = "none";
        }

        // Show the hidden items in the mobile navbar
        hiddenIndex.forEach((index) => {
            mobileItems[index].style.display = null;
        });
    },

    // Default handlers
    onBlur: () => {},
    onFocus: () => {},

    ...extraData,
});

window.MarkdownEditor = MarkdownEditor;
