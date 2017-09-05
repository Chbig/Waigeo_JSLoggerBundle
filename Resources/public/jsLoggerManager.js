var jsLoggerManager = {

    init: function (saveLogErrorUrl) {
        window.onerror = function (messageOrEvent, source, lineno, colno, error) {
            var message = "Impossible de récupérer le message de l'erreur originelle.";

            if(messageOrEvent != null){
                if(typeof(messageOrEvent) == "string"){
                    message = messageOrEvent;
                }

                if(typeof(messageOrEvent) == "object"){
                    message = JSON.stringify(messageOrEvent);
                }
            }

            $.ajax(saveLogErrorUrl, {
                type: "GET",
                data: {
                    message: messageOrEvent,
                    url: source,
                    lineNumber: lineno,
                    colNumber: colno,
                    userAgent: jsLoggerManager.getNavigator()
                }
            });
        };
    },

    getNavigator: function () {
        var ua = navigator.userAgent, tem,
            M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
        if (/trident/i.test(M[1])) {
            tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
            return 'IE ' + (tem[1] || '');
        }
        if (M[1] === 'Chrome') {
            tem = ua.match(/\b(OPR|Edge)\/(\d+)/);
            if (tem != null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
        }
        M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
        if ((tem = ua.match(/version\/(\d+)/i)) != null) M.splice(1, 1, tem[1]);
        return M.join(' ');
    }
};
