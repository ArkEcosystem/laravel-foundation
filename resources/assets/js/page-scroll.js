window.scrollToQuery = (selector, anchor = "#navbar") => {
    const anchorElement = document.querySelector(anchor);

    window.scrollTo({
        top:
            document.querySelector(selector).offsetTop -
            (anchorElement ? anchorElement.clientHeight : 0),
        behavior: "smooth",
    });
};
