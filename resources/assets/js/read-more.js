const ReadOnly = ({ value }) => ({
    value,
    showMore: false,
    showExpand: false,
    init() {
        this.truncate();
    },
    truncate() {
        this.$nextTick(() => {
            const el = this.$root.querySelector(".read-more-content");

            el.innerHTML = "";
            el.appendChild(document.createTextNode(this.value));

            if (!this.hasOverflow(el)) {
                return;
            }

            let length = this.value.length;
            do {
                const a = this.value.substr(0, length);
                const truncated = a + "...";

                el.innerHTML = "";
                el.appendChild(document.createTextNode(truncated));

                length--;

                this.showExpand = true;
            } while (length > 1 && this.hasOverflow(el));
        });
    },
    showAll() {
        const el = this.$root.querySelector(".read-more-content");

        el.innerHTML = "";
        el.appendChild(document.createTextNode(this.value));
        this.showMore = true;
    },
    hideOptionAndTruncate() {
        this.showExpand = false;

        this.truncate();
    },
    hasOverflow(el) {
        return el.offsetWidth < el.scrollWidth;
    },
});

export default ReadOnly;
