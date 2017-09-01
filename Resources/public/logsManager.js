var MyDateField = function (config) {
    jsGrid.Field.call(this, config);
};

MyDateField.prototype = new jsGrid.Field({
    itemTemplate: function (value) {
        if (value == null)
            return "";

        var date = new Date(value.timestamp * 1000);

        return ("0" + date.getDate()).slice(-2) + "/" + ("0" + (date.getMonth() + 1)).slice(-2) + "/" + date.getFullYear();
    }
});

jsGrid.fields.date = MyDateField;

var logsManager = {

    /*
    Initialise la page de gestion des logs d'erreurs JavaScript
     */
    init: function(){
        var me = this;

        me.initComponents();
    },

    initComponents: function(){
        var me = this;

        me.logsCount = $('#itemsCount');

        var gridColumns = [
            {
                title: "Créé le",
                name: "createdDate",
                type: "date",
                width: 45
            },
            {
                title: "Page",
                name: "url",
                type: "text",
                width: 100
            },
            {
                title: "Erreur",
                name: "message",
                type: "text",
                width: 125
            },
            {
                title: "N° de ligne",
                name: "lineNumber",
                type: "text",
                width: 30
            },
            {
                title: "N° de colonne",
                name: "colNumber",
                type: "text",
                width: 30
            },
            {
                title: "Navigateur",
                name: "userAgent",
                type: "text",
                width: 100
            }
        ];

        me.logsGrid = $("#logsGrid").jsGrid({
            width: "100%",

            filtering: true,
            editing: false,
            sorting: true,
            paging: true,
            autoload: true,

            pageLoading: true,
            pageSize: 15,
            pageButtonCount: 5,

            noDataContent: "Aucune erreur trouvée",
            pagerFormat: "Pages: {first} {prev} {pages} {next} {last} {pageIndex} sur {pageCount}",
            pagePrevText: "<",
            pageNextText: ">",
            pageFirstText: "Première",
            pageLastText: "Dernière",
            pageNavigatorNextText: "...",
            pageNavigatorPrevText: "...",
            loadMessage: "Chargement en cours ...",

            controller: {
                loadData: function (filter) {
                    var d = $.Deferred();

                    $.ajax({
                        url: me.urls.listLogs,
                        dataType: "json",
                        data: {
                            pageSize: filter.pageSize,
                            pageIndex: filter.pageIndex,
                            filterUrl: filter.url,
                            filterMessage: filter.message,
                            filterUserAgent: filter.userAgent,
                            sortField: filter.sortField,
                            sortOrder: filter.sortOrder
                        }

                    }).done(function (response) {
                        if (response.success) {
                            d.resolve(response.data);
                            me.logsCount.text(response.data.itemsCount);
                        }
                        else {
                            me.showToastError("Erreur", "Une erreur s'est produite lors de la récupération des erreurs");
                        }
                    });

                    return d.promise();
                }
            },
            fields: gridColumns
        });
    },

    /**
     * Affiche un masque de chargement sur toute la page empechant toutes actions
     */
    maskLoad: function () {
        $(".preloader").fadeIn();
    },

    /**
     * Retire le masque de chargement
     */
    unmask: function () {
        $(".preloader").fadeOut();
    },

    /**
     * Affiche un toast d'erreur
     * @param title Titre
     * @param message Message
     */
    showToastError: function (title, message) {
        $.toast({
            heading: title,
            text: message,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 5000,
            stack: 6
        });
    }
};
