import Editor from "@toast-ui/editor";

import {
    // simplecastPlugin,
    // youtubePlugin,
    // twitterPlugin,
    // undoPlugin,
    // redoPlugin,
    underlinePlugin,
    // headingPlugin,
    // previewPlugin,
    // referencePlugin,
    // alertPlugin,
    // linkCollectionPlugin,
    embedLinkPlugin,
} from "./plugins/index.js";

import { getWordsAndCharactersCount, uploadImage } from "./utils/utils.js";

// const AVERAGE_WORDS_READ_PER_MINUTE = 200;

// Editor.setLanguage(["en", "en-US"], {
//     "Unordered list": "Unordered List",
//     "Ordered list": "Ordered List",
//     "Insert link": "Insert link",
//     "Insert CodeBlock": "Insert Code Block",
//     "Insert table": "Insert Table",
//     "Insert image": "Insert Image",
//     "Link text": "Link Text",
//     "Add row": "Add Row",
//     "Add col": "Add Col",
//     "Remove row": "Remove Row",
//     "Remove col": "Remove Col",
//     "Align left": "Align Left",
//     "Align center": "Align Center",
//     "Align right": "Align Right",
//     "Remove table": "Remove Table",
//     "Text color": "Text Color",
//     "Auto scroll enabled": "Auto Scroll Enabled",
//     "Auto scroll disabled": "Auto Scroll Disabled",
// });

// Based on: https://github.com/nhn/tui.editor/blob/16e0b88ba2cac0631ffdf8777a22bb696380d2fb/apps/editor/src/markdown/helper/list.ts#L62
const reList = /(^\s*)([-*+])/;
const reOrderedList = /(^\s*)([\d])+\.( \[[ xX]])? /;

const MarkdownEditor = (
    height = null,
    toolbar = "basic",
    charsLimit = "0",
    extraData = {}
) => ({
    editor: null,
    toolbar: null,
    showOverlay: false,
    charsLimit: parseInt(charsLimit),
    charsCount: 0,
    wordsCount: 0,
    readMinutes: 0,
    height: height || "600px",
    loadingCharsCount: false,
    loadingCharsTimeout: false,
    loadingCharsAbortController: null,
    toolbarItems:
        toolbar === "basic"
            ? [
                  // ...Undo & redo

                  "divider",

                  "bold",
                  "italic",
                  "divider",

                  // ...Headers

                  "divider",

                  "ol",
                  "ul",

                  "divider",

                  "link",

                  // ...Plugins, etc
              ]
            : [
                  // ...Undo & redo

                  "divider",

                  "bold",
                  "italic",
                  "strike",
                  "quote",
                  "divider",

                  // ...Headers

                  "divider",

                  "ol",
                  "ul",
                  "table",
                  "image",

                  "divider",

                  "link",
                  "code",
                  "codeblock",

                  "divider",

                  "divider",

                  // ...Plugins, etc
              ],
    plugins:
        toolbar === "basic"
            ? ["redo", "undo"]
            : [
                  "simplecast",
                  "twitter",
                  "youtube",
                  "linkcollection",
                  "heading2",
                  "heading3",
                  "heading4",
                  "heading5",
                  "heading6",
                  "underline",
                  "redo",
                  "undo",
                  "reference",
                  "alert",
                  "embedlink",
              ],
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
        this.editor.eventEmitter.emit("openPopup", "image", {});
    },
    link() {
        this.editor.eventEmitter.emit("openPopup", "link", {});
    },
    embedLink() {
        Livewire.emit('openModal', 'embed-link-modal');
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
                    // blur: this.onBlur,
                    // focus: this.onFocus,
                    // toolbarItems: [],
                },
                plugins: [
                    underlinePlugin,
                    // embedLinkPlugin,
                ],
                hooks: {
                    addImageBlobHook: (blob, callback) => {
                        const alt =
                            document.querySelector("#toastuiAltTextInput")
                                .value || blob.name;
                        // const markdownEditor = this.editor.mdEditor.getEditor();
                        const loadingLabel = `Uploading ${blob.name}…`;

                        const loadingPlaceholder = `![${loadingLabel}]()`;

                        const csrfToken = document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content;

                        if (!csrfToken) {
                            throw new Error(
                                "We were unable to get the csrfToken for this request"
                            );
                        }

                        // Show a loading message while the image is uploaded
                        callback("", loadingLabel);

                        const placeholderSelection = this.editor.getSelection();

                        uploadImage(blob, csrfToken).then((response) => {
                            if (!response.url) {
                                throw new Error("Received invalid response");
                            }

                            // Select the placeholder again in case user unselected it.
                            // It will be replaced in the following callback
                            this.editor.setSelection(
                                [
                                    placeholderSelection[1][0],
                                    placeholderSelection[1][1] -
                                        loadingPlaceholder.length -
                                        2,
                                ],
                                [
                                    placeholderSelection[1][0],
                                    placeholderSelection[1][1],
                                ]
                            );

                            callback(response.url, alt);
                        });

                        return true;
                    },
                },
            });

            this.getWordsAndCharactersCount(this.editor.getMarkdown());

            console.log(this.editor);
            // this.editor = new Editor({
            //     el: this.$refs.editor,
            //     initialEditType: "markdown",
            //     usageStatistics: false,
            //     hideModeSwitch: true,
            //     previewStyle: "tab",
            //     previewHighlight: false,
            //     initialValue: input.value,
            //     events: {
            //         change: () => this.onChangeHandler(),
            //         blur: this.onBlur,
            //         focus: this.onFocus,
            //     },
            //     toolbarItems: this.toolbarItems,
            //     // We dont need any "sanitized" HTML since we dont use the `preview`
            //     // mode, so doing this:
            //     // 1. Prevents security issues
            //     // 2. Makes the editor way faster
            //     customHTMLSanitizer: () => "",
            //     plugins: this.getPlugins(),
            //     hooks: {
            //         addImageBlobHook: (blob, callback) => {
            //             const alt =
            //                 document.querySelector("input.te-alt-text-input")
            //                     .value || blob.name;
            //             const markdownEditor = this.editor.mdEditor.getEditor();
            //             const loadingLabel = `Uploading ${blob.name}…`;
            //             const loadingPlaceholder = `![${loadingLabel}]()`;

            //             const csrfToken = document.querySelector(
            //                 'meta[name="csrf-token"]'
            //             ).content;

            //             if (!csrfToken) {
            //                 throw new Error(
            //                     "We were unable to get the csrfToken for this request"
            //                 );
            //             }

            //             // Show a loading message while the image is uploaded
            //             callback("", loadingLabel);

            //             uploadImage(blob, csrfToken).then((response) => {
            //                 if (!response.url) {
            //                     throw new Error("Received invalid response");
            //                 }

            //                 const currentCursor = markdownEditor.getCursor();
            //                 markdownEditor.setValue(
            //                     markdownEditor
            //                         .getValue()
            //                         .replace(loadingPlaceholder, "")
            //                 );
            //                 currentCursor.ch =
            //                     currentCursor.ch - loadingPlaceholder.length;
            //                 markdownEditor.setCursor(currentCursor);

            //                 callback(response.url, alt);
            //             });

            //             return true;
            //         },
            //     },
            // });

            // const events = this.editor.eventManager.events;
            // const handlers = events.get("command");
            // handlers.unshift(this.forceHttpsLinkHandler);
            // events.set("command", handlers);

            // // Since we dont use the preview and is hidden, the scroll event
            // // creates some exceptions that are fixed by removing these listeners.
            // this.editor.preview.eventManager.removeEventHandler(
            //     "previewRenderAfter"
            // );
            // this.editor.preview.eventManager.removeEventHandler("scroll");

            // editor.getCodeMirror().setOption("lineNumbers", true);

            // this.toolbar = this.editor.getUI().getToolbar();

            // this.toolbarItems = this.toolbar.getItems();

            // this.addIconsToTheButtons();

            // this.initOverlay();

            // this.removeScrollSyncButton();

            // this.editor.eventManager.listen("openDropdownToolbar", (e) => {
            //     this.hideAllTooltips();
            // });

            // this.adjustHeight();

            // window.onresize = () => {
            //     this.adjustHeight();
            // };
        } catch (error) {
            alert("Something went wrong!");
            console.error(error);
        }
    },
    adjustHeight() {
        const hasPreview = this.editor.getCurrentPreviewStyle() === "vertical";
        const pageWidth = document.documentElement.clientWidth;

        if (pageWidth <= 768 && hasPreview) {
            this.editor.height(`${parseInt(this.height, 10) * 2}px`);
        } else {
            this.editor.height(this.height);
        }
    },
    hideAllTooltips() {
        this.toolbar.getItems().forEach((i) => i._onOut && i._onOut());
    },
    removeScrollSyncButton() {
        const scrollButton = this.editor
            .getUI()
            .el.querySelector(".tui-scrollsync");
        scrollButton.previousSibling.remove();
        scrollButton.remove();
    },
    getPlugins() {
        const {
            iconH1,
            iconH2,
            iconH3,
            iconH4,
            iconYoutube,
            iconTwitter,
            iconPodcast,
            iconUndo,
            iconUnderline,
            iconRedo,
            iconPreview,
            iconReference,
            iconAlert,
            iconLinkcollection,
            iconEmbedLink,
        } = this.$refs;

        const buttonIndex = this.toolbarItems.length;

        const plugins = {
            alert: (editor) => alertPlugin(editor, buttonIndex, iconAlert),
            preview: (editor) =>
                previewPlugin(editor, buttonIndex, iconPreview, this.height),
            reference: (editor) =>
                referencePlugin(editor, buttonIndex, iconReference),
            linkcollection: (editor) =>
                linkCollectionPlugin(
                    editor,
                    buttonIndex - 1,
                    iconLinkcollection
                ),
            youtube: (editor) =>
                youtubePlugin(editor, buttonIndex - 1, iconYoutube),
            simplecast: (editor) =>
                simplecastPlugin(editor, buttonIndex - 1, iconPodcast),
            twitter: (editor) =>
                twitterPlugin(editor, buttonIndex - 1, iconTwitter),
            embedlink: (editor) =>
                embedLinkPlugin(editor, buttonIndex - 1, iconEmbedLink),
            heading4: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH4, 4),
            heading3: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH3, 3),
            heading2: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH2, 2),
            heading1: (editor) =>
                headingPlugin(editor, buttonIndex - 11, iconH1, 1),
            underline: (editor) =>
                underlinePlugin(editor, buttonIndex - 15, iconUnderline),
            redo: (editor) => redoPlugin(editor, 0, iconRedo),
            undo: (editor) => undoPlugin(editor, 0, iconUndo),
        };

        Object.keys(plugins).forEach((pluginName) => {
            if (!this.plugins.includes(pluginName)) {
                delete plugins[pluginName];
            }
        });

        return Object.values(plugins);
    },
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
    addIconsToTheButtons() {
        const {
            iconBold,
            iconItalic,
            iconStrike,
            iconQuote,
            iconOl,
            iconUl,
            iconTable,
            iconImage,
            iconLink,
            iconCode,
            iconCodeblock,
        } = this.$refs;

        const buttons = [
            { name: "italic", icon: iconItalic },
            { name: "bold", icon: iconBold },
            { name: "strike", icon: iconStrike },
            { name: "quote", icon: iconQuote },
            { name: "ol", icon: iconOl },
            { name: "ul", icon: iconUl },
            { name: "table", icon: iconTable },
            { name: "image", icon: iconImage },
            { name: "link", icon: iconLink },
            { name: "code", icon: iconCode },
            { name: "codeblock", icon: iconCodeblock },
        ];

        buttons.map(({ name, icon }) => {
            const button = this.toolbarItems.find((i) =>
                i.className.includes(`tui-${name}`)
            );
            if (button) {
                button.el.innerHTML = icon.innerHTML;
            }
        });
    },
    initOverlay() {
        this.editor.eventManager.addEventType("popupShown");
        this.editor.eventManager.addEventType("popupHidden");
        this.editor.eventManager.listen(
            "popupShown",
            () => (this.showOverlay = true)
        );
        this.editor.eventManager.listen(
            "popupHidden",
            () => (this.showOverlay = false)
        );

        this.editor.getUI()._popups.forEach((popup) => {
            popup.customEventManager.on(
                "shown",
                () => (this.showOverlay = true)
            );
            popup.customEventManager.on(
                "hidden",
                () => (this.showOverlay = false)
            );
        });
    },
    onChangeHandler() {
        // this.hideAllTooltips();

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
                const textContent =
                    $from?.doc.child(endIndex)?.textContent || "";

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

            fromMarks.forEach((mark) => console.log("from", mark.type.name));
            toMarks.forEach((mark) => console.log("to", mark.type.name));

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

    // Default handlers
    onBlur: () => {},
    onFocus: () => {},

    ...extraData,
});

window.MarkdownEditor = MarkdownEditor;
