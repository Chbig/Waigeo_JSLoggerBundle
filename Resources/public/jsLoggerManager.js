var jsLoggerManager = {

    init: function(saveLogErrorUrl){
        window.onerror = function(messageOrEvent, source, lineno, colno, error){
            $.ajax(saveLogErrorUrl, {
                type: "GET",
                data: {
                    message: messageOrEvent,
                    url: source,
                    lineNumber: lineno,
                    colNumber: colno,
                    userAgent: navigator.userAgent
                }
            });
        };
    }
};
