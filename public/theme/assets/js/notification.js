const notifier = (type, message) => {
    const notyf = new Notyf({
        position: {
            x: "right",
            y: "top",
        },
        types: [
            {
                type: "info",
                background: "#2361ce",
                icon: {
                    className: "fas fa-info-circle",
                    tagName: "span",
                    color: "#fff",
                },
                dismissible: false,
                duration: 5000,
                className: "max-width: 50em !important",
            },
            {
                type: "warning",
                background: "#F5B759",
                icon: {
                    className: "fas fa-exclamation-triangle",
                    tagName: "span",
                    color: "#fff",
                },
                dismissible: false,
                duration: 5000,
            },
            {
                type: "error",
                background: "#FA5252",
                icon: {
                    className: "fas fa-times",
                    tagName: "span",
                    color: "#fff",
                },
                dismissible: false,
                duration: 5000,
            },
            {
                type: "success",
                background: "#10b981",
                icon: {
                    className: "fas fa-check",
                    tagName: "span",
                    color: "#fff",
                },
                dismissible: false,
                duration: 5000,
            },
        ],
    });
    console.log(type, message);
    notyf.open({
        type: `${type}`,
        message: `${message}`,
    });
};
