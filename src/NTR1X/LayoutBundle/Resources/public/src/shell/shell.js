(function(Vue, $) {

    Vue.component('shell', {
        template: '#shell',
        props: {
            selection: Object,
            settings: Object,
            model: Object,
        },
        data: function() {
            return {
                globals: {
                    selection: this.selection,
                    settings: this.settings,
                    model: this.model,
                    data: this.data,
                },
            };
        },
        ready: function() {

            // TODO Тут игнорируется тот факт, что запись может быть с _action: removed

            if (!this.selection.category) {
                if (this.settings.categories.length > 0) {
                    var sub = this.settings.categories[0];
                    if (sub.categories.length > 0) {
                        this.selection.category = sub.categories[0];
                    }
                }
            }

            if (!this.selection.domain) {
                if (this.model.domains.length > 0) {
                    this.selection.domain = this.model.domains[0];
                    this.selection.page = null;
                    this.selection.source = null;
                }
            }

            if (!this.selection.page) {
                if (this.model.pages.length > 0) {
                    this.selectPage(this.model.pages[0]);
                }
            }

            if (!this.selection.source) {
                if (this.selection.page && this.selection.page.sources.length > 0) {
                    this.selection.source = this.selection.page.sources[0];
                }
            }
        },
        methods: {

            getWidget: function(id) {

                for (var i = 0; i < this.settings.widgets.length; i++) {
                    var w = this.settings.widgets[i];
                    if (w.id == id) {
                        return w;
                    }
                }

                return null;
            },

            selectPage: function(page) {

                this.selection.page = page;
                this.selection.source = null;

                var data = {};

                // TODO Сделать запросы

                if (page && page.sources) {
                    for (var i = 0; i < page.sources.length; i++) {
                        var s = page.sources[i];
                        data[s.name] = [
                            { one: 11, two: 12 },
                            { one: 21, two: 22 },
                            { one: 31, two: 32 },
                            { one: 41, two: 42 },
                        ];
                    }
                }

                this.globals.data = data;
            }
        },
        events: {
            pull: function(data) {
                $.ajax({
                    url: '/settings',
                    method: 'GET',
                    dataType: "json"
                })
                .done((d) => {
                    Object.assign(this.model, d);
                })
            },
            push: function(data) {
                $.ajax({
                    url: '/settings/do-update',
                    method: 'POST',
                    dataType: "json",
                    data: JSON.stringify(this.model),
                    contentType: "application/json",
                })
                .done((d) => {
                    Object.assign(this.model, d);
                })
            },
            tree: function(data) {
                console.log(this);
            },
            selectCategory: function(data) {
                this.selection.category = data.item;
            },
            selectDomain: function(data) {
                this.selection.domain = data.item;
            },
            selectPage: function(data) {
                this.selectPage(data.item);
            },
            selectSource: function(data) {
                this.selection.source = data.item;
            },
        }
    });

})(Vue, jQuery, undefined);
