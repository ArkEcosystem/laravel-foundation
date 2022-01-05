export default function underlinePlugin(name) {
    return function (context) {
        const { pmState } = context;

        return {
            markdownCommands: {
                underline(_options, context, dispatch) {
                    const { tr: transaction, selection, schema } = context;
                    const slice = selection.content();
                    const textContent = slice.content.textBetween(
                        0,
                        slice.content.size
                    );
                    const openTag = `<ins>`;
                    const closeTag = `</ins>`;

                    let replace;

                    if (
                        textContent.startsWith(openTag) &&
                        textContent.endsWith(closeTag)
                    ) {
                        replace = textContent
                            .substr(openTag.length)
                            .substr(
                                0,
                                textContent.length -
                                    openTag.length -
                                    closeTag.length
                            );
                    } else {
                        replace = `${openTag}${textContent}${closeTag}`;
                    }

                    transaction
                        .replaceSelectionWith(schema.text(replace))
                        .setSelection(
                            pmState.TextSelection.create(
                                transaction.doc,
                                selection.from,
                                selection.from + replace.length
                            )
                        );

                    document
                        .querySelector(`#markdown-editor-${name} .ProseMirror`)
                        .focus();

                    dispatch(transaction);

                    return true;
                },
            },
        };
    };
}
