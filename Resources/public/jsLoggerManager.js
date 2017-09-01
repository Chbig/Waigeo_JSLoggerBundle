var jsLoggerManager = {

    init: function(saveLogErrorUrl){
        window.onerror = function(messageOrEvent, source, lineno, colno, error){
            console.log(arguments);

            $.ajax(saveLogErrorUrl, {
                type: "GET",
                data: {
                    message: messageOrEvent,
                    url: source,
                    lineNumber: lineno,
                    colNumber: colno,
                    userAgent: navigator.userAgent
                },
                success: function (response) {
                    console.log("log enregistré");
                },
                error: function (xhr, s, arg3) {
                    console.log("fail");
                }
            });
        };
    }
};
