//
// Global init of core components
//

// Init components
var TI_Components = function () {
    // Public methods
    return {
        init: function () {
            TI_App.init();
			TI_Drawer.init();
			TI_Menu.init();
			TI_Scroll.init();
			TI_Sticky.init();
			TI_Swapper.init();
			TI_Toggle.init();
			TI_Scrolltop.init();
			TI_Dialer.init();
			TI_ImageInput.init();
			TI_PasswordMeter.init();
        }
    }
}();

// On document ready
if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", function() {
		TI_Components.init();
	});
 } else {
	TI_Components.init();
 }

 // Init page loader
window.addEventListener("load", function() {
    TI_App.hidePageLoading();
});

// Declare TI_App for Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.TI_Components = module.exports = TI_Components;
}
"use strict";

// Class definition
var TI_App = function () {
    var initialized = false;
    var select2FocusFixInitialized = false;
    var countUpInitialized = false;
    var removeVietnameseAccents = function() {
        var str = this;
        // remove accents
        var from = "àáãảạăằắẳẵặâầấẩẫậèéẻẽẹêềếểễệđùúủũụưừứửữựòóỏõọôồốổỗộơờớởỡợìíỉĩịäëïîöüûñçýỳỹỵỷ",
            to   = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeduuuuuuuuuuuoooooooooooooooooiiiiiaeiiouuncyyyyy";
        for (var i=0, l=from.length ; i < l ; i++) {
            str = str.replace(RegExp(from[i], "gi"), to[i]);
        }

        str = str.toLowerCase()
            .trim()
            .replace(/[^a-z0-9\-]/g, '-')
            .replace(/-+/g, '');

        return str;
    }
    var createBootstrapTooltip = function (el, options) {
        if (el.getAttribute("data-ti-initialized") === "1") {
            return;
        }

        var delay = {};

        // Handle delay options
        if (el.hasAttribute('data-bs-delay-hide')) {
            delay['hide'] = el.getAttribute('data-bs-delay-hide');
        }

        if (el.hasAttribute('data-bs-delay-show')) {
            delay['show'] = el.getAttribute('data-bs-delay-show');
        }

        if (delay) {
            options['delay'] = delay;
        }

        // Check dismiss options
        if (el.hasAttribute('data-bs-dismiss') && el.getAttribute('data-bs-dismiss') == 'click') {
            options['dismiss'] = 'click';
        }

        // Initialize popover
        var tp = new bootstrap.Tooltip(el, options);

        // Handle dismiss
        if (options['dismiss'] && options['dismiss'] === 'click') {
            // Hide popover on element click
            el.addEventListener("click", function (e) {
                tp.hide();
            });
        }

        el.setAttribute("data-ti-initialized", "1");

        return tp;
    }

    var selectAllRows = function () {
        const selectAll = document.querySelectorAll('[data-select-all="true"]')

        if (!selectAll.length) {
            return;
        }

        Object.entries(selectAll).forEach(([key, elm]) => {
            let target = elm.getAttribute('data-target');
            if (!target) {
                return;
            }
            elm.addEventListener('change', function (e) {
                e.preventDefault();
                if (elm.checked) {
                    const table = document.getElementById(target);
                    const checkboxes = table.querySelectorAll('.inrow-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = true;
                    });
                } else {
                    const table = document.getElementById(target);
                    const checkboxes = table.querySelectorAll('.inrow-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                }
                return false;
            });
        });
        TI_Util.on(document.body, '.inrow-checkbox', 'change', function (e) {
            const parent_id = this.getAttribute('data-parent');
            let table_id = '';
            if (!parent_id) {
                const table = this.closest('table');
                table_id = table.id;
            } else {
                table_id = parent_id;
            }

            const parent = document.getElementById(table_id);


            const checkboxes = parent.querySelectorAll('.inrow-checkbox');

            const selectAll = document.querySelector('[data-target="' + table_id + '"]');
            const checked = parent.querySelectorAll('.inrow-checkbox:checked');
            if (checkboxes.length === checked.length) {
                selectAll.checked = true;
            } else {
                selectAll.checked = false;
            }
        });
    }

    var createBootstrapTooltips = function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            createBootstrapTooltip(tooltipTriggerEl, {});
        });
    }

    var createBootstrapPopover = function (el, options) {
        if (el.getAttribute("data-ti-initialized") === "1") {
            return;
        }

        var delay = {};

        // Handle delay options
        if (el.hasAttribute('data-bs-delay-hide')) {
            delay['hide'] = el.getAttribute('data-bs-delay-hide');
        }

        if (el.hasAttribute('data-bs-delay-show')) {
            delay['show'] = el.getAttribute('data-bs-delay-show');
        }

        if (delay) {
            options['delay'] = delay;
        }

        // Handle dismiss option
        if (el.getAttribute('data-bs-dismiss') == 'true') {
            options['dismiss'] = true;
        }

        if (options['dismiss'] === true) {
            options['template'] = '<div class="popover" role="tooltip"><div class="popover-arrow"></div><span class="popover-dismiss btn btn-icon"></span><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        }

        // Initialize popover
        var popover = new bootstrap.Popover(el, options);

        // Handle dismiss click
        if (options['dismiss'] === true) {
            var dismissHandler = function (e) {
                popover.hide();
            }

            el.addEventListener('shown.bs.popover', function () {
                var dismissEl = document.getElementById(el.getAttribute('aria-describedby'));
                dismissEl.addEventListener('click', dismissHandler);
            });

            el.addEventListener('hide.bs.popover', function () {
                var dismissEl = document.getElementById(el.getAttribute('aria-describedby'));
                dismissEl.removeEventListener('click', dismissHandler);
            });
        }

        el.setAttribute("data-ti-initialized", "1");

        return popover;
    }

    var createBootstrapPopovers = function () {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));

        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            createBootstrapPopover(popoverTriggerEl, {});
        });
    }

    var createBootstrapToasts = function () {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function (toastEl) {
            if (toastEl.getAttribute("data-ti-initialized") === "1") {
                return;
            }

            toastEl.setAttribute("data-ti-initialized", "1");

            return new bootstrap.Toast(toastEl, {})
        });
    }

    var createButtons = function () {
        var buttonsGroup = [].slice.call(document.querySelectorAll('[data-ti-buttons="true"]'));

        buttonsGroup.map(function (group) {
            if (group.getAttribute("data-ti-initialized") === "1") {
                return;
            }

            var selector = group.hasAttribute('data-ti-buttons-target') ? group.getAttribute('data-ti-buttons-target') : '.btn';
            var activeButtons = [].slice.call(group.querySelectorAll(selector));

            // Toggle Handler
            TI_Util.on(group, selector, 'click', function (e) {
                activeButtons.map(function (button) {
                    button.classList.remove('active');
                });

                this.classList.add('active');
            });

            group.setAttribute("data-ti-initialized", "1");
        });
    }

    var createDateRangePickers = function() {
        // Check if jQuery included
        if (typeof jQuery == 'undefined') {
            return;
        }

        // Check if daterangepicker included
        if (typeof $.fn.daterangepicker === 'undefined') {
            return;
        }

        var elements = [].slice.call(document.querySelectorAll('[data-ti-daterangepicker="true"]'));
        // var start = moment().subtract(29, 'days');
        var start  = moment('01/01/2024', 'DD/MM/YYYY');
        var end = moment().add(1, 'days');

        elements.map(function (element) {
            if (element.getAttribute("data-ti-initialized") === "1") {
                return;
            }


            moment.locale('vn');
            var display = element.querySelector('div');
            var isSingle = element.getAttribute("data-ti-single-datepicker") === "true";
            var attrOpens  = element.hasAttribute('data-ti-daterangepicker-opens') ? element.getAttribute('data-ti-daterangepicker-opens') : 'left';
            var range = element.getAttribute('data-ti-daterangepicker-range');
            var format = element.getAttribute('data-ti-daterangepicker-format') || 'DD/MM/YYYY';
            var initialDate = element.getAttribute('data-ti-daterangepicker-initial') === "true";
            var endDate = element.getAttribute('data-ti-enddate');
            var cb = function(start, end) {
                var current = moment();

                if (display && !isSingle && initialDate) {
                    if ( (current.isSame(start, "day") && current.isSame(end, "day")) ) {
                        display.innerHTML = start.format(format);
                    } else {
                        display.innerHTML = start.format(format) + ' - ' + end.format(format);
                    }
                } else if (display && isSingle && initialDate) {
                    display.innerHTML = start.format(format);
                }

                if (!initialDate) {
                    element.setAttribute('data-ti-daterangepicker-initial', 'true');
                    initialDate = true;
                }
            }

            if ( range === "today" ) {
                start = moment().add(1, 'days');
                end = moment().add(1, 'days');
            }
            $(element).daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: "DD/MM/YYYY",
                    separator: " - ",
                    applyLabel: "Chấp nhận",
                    cancelLabel: "Hủy",
                    fromLabel: "Từ",
                    toLabel: "Đến",
                    customRangeLabel: "Tùy chọn",
                    daysOfWeek: [
                        "CN",
                        "T2",
                        "T3",
                        "T4",
                        "T5",
                        "T6",
                        "T7"
                    ],
                    monthNames: [
                        "Tháng 1",
                        "Tháng 2",
                        "Tháng 3",
                        "Tháng 4",
                        "Tháng 5",
                        "Tháng 6",
                        "Tháng 7",
                        "Tháng 8",
                        "Tháng 9",
                        "Tháng 10",
                        "Tháng 11",
                        "Tháng 12"
                    ],
                    firstDay: 1
                },
                opens: attrOpens,
                singleDatePicker: isSingle,
                ...(!isSingle ? {
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Hôm nay': [moment(), moment()],
                        'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                        '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                        'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                } : {}),
            }, cb);

            cb(start, end);

            element.setAttribute("data-ti-initialized", "1");
        });
    }

    var createSelect2 = function () {
        // Check if jQuery included
        if (typeof jQuery == 'undefined') {
            return;
        }

        // Check if select2 included
        if (typeof $.fn.select2 === 'undefined') {
            return;
        }

        var elements = [].slice.call(document.querySelectorAll('[data-control="select2"], [data-ti-select2="true"]'));

        elements.map(function (element) {
            if (element.getAttribute("data-ti-initialized") === "1") {
                return;
            }



            var options = {
                dir: document.body.getAttribute('direction'),
                wrapClass: "wrap d-flex align-items-center w-100",
            };

            if (element.getAttribute('data-checkbox-type') === 'badge') {
                options.wrapClass = 'wrap-badge d-flex align-items-center lh-0 py-4 w-100';
            }

            if (element.hasAttribute('data-dropdown-width')) {
                options.width = element.getAttribute('data-dropdown-width');
            }

            if (element.getAttribute('data-hide-search') == 'true') {
                options.minimumResultsForSearch = Infinity;
            }

            // Result template
            if (element.hasAttribute('data-result-template')) {
                var template_id = element.getAttribute('data-result-template');

                if (template_id) {
                    var template = document.getElementById(template_id).innerHTML;
                    const renderer = Handlebars.compile(template);

                    options.templateResult = function(state) {
                        if (!state.id) {
                            return state.text;
                        }
                        var raw_data = state.element.getAttribute("data-item-data");
                        if (raw_data) {
                            var data = JSON.parse(raw_data);
                            if (!data.item) {
                                data.item = state;
                            }

                            var render_html = renderer(data);
                            return jQuery(render_html);
                        }

                        return state.text;
                    }
                }
            }

            if (element.hasAttribute('multiple') && element.getAttribute('data-multi-checkboxes') === 'true') {
                options.placeholder = element.getAttribute('data-label') || 'Select options';
                $(element).select2MultiCheckboxes(options);
            } else {

                $(element).select2(options);
            }

            element.setAttribute("data-ti-initialized", "1");
        });

        /*
        * Hacky fix for a bug in select2 with jQuery 3.6.0's new nested-focus "protection"
        * see: https://github.com/select2/select2/issues/5993
        * see: https://github.com/jquery/jquery/issues/4382
        *
        * TODO: Recheck with the select2 GH issue and remove once this is fixed on their side
        */

        if (select2FocusFixInitialized === false) {
            select2FocusFixInitialized = true;

            $(document).on('select2:open', function(e) {
                var elements = document.querySelectorAll('.select2-container--open .select2-search__field');
                if (elements.length > 0) {
                    elements[elements.length - 1].focus();
                }
            });
        }
    }

    var createAutosize = function () {
        if (typeof autosize === 'undefined') {
            return;
        }

        var inputs = [].slice.call(document.querySelectorAll('[data-ti-autosize="true"]'));

        inputs.map(function (input) {
            if (input.getAttribute("data-ti-initialized") === "1") {
                return;
            }

            autosize(input);

            input.setAttribute("data-ti-initialized", "1");
        });
    }

    var createCountUp = function () {
        if (typeof countUp === 'undefined') {
            return;
        }

        var elements = [].slice.call(document.querySelectorAll('[data-ti-countup="true"]:not(.counted)'));

        elements.map(function (element) {
            if (TI_Util.isInViewport(element) && TI_Util.visible(element)) {
                if (element.getAttribute("data-ti-initialized") === "1") {
                    return;
                }

                var options = {};

                var value = element.getAttribute('data-ti-countup-value');
                value = parseFloat(value.replace(/,/g, ""));

                if (element.hasAttribute('data-ti-countup-start-val')) {
                    options.startVal = parseFloat(element.getAttribute('data-ti-countup-start-val'));
                }

                if (element.hasAttribute('data-ti-countup-duration')) {
                    options.duration = parseInt(element.getAttribute('data-ti-countup-duration'));
                }

                if (element.hasAttribute('data-ti-countup-decimal-places')) {
                    options.decimalPlaces = parseInt(element.getAttribute('data-ti-countup-decimal-places'));
                }

                if (element.hasAttribute('data-ti-countup-prefix')) {
                    options.prefix = element.getAttribute('data-ti-countup-prefix');
                }

                if (element.hasAttribute('data-ti-countup-separator')) {
                    options.separator = element.getAttribute('data-ti-countup-separator');
                }

                if (element.hasAttribute('data-ti-countup-suffix')) {
                    options.suffix = element.getAttribute('data-ti-countup-suffix');
                }

                var count = new countUp.CountUp(element, value, options);

                count.start();

                element.classList.add('counted');

                element.setAttribute("data-ti-initialized", "1");
            }
        });
    }

    var createCountUpTabs = function () {
        if (typeof countUp === 'undefined') {
            return;
        }

        if (countUpInitialized === false) {
            // Initial call
            createCountUp();

            // Window scroll event handler
            window.addEventListener('scroll', createCountUp);
        }

        // Tabs shown event handler
        var tabs = [].slice.call(document.querySelectorAll('[data-ti-countup-tabs="true"][data-bs-toggle="tab"]'));
        tabs.map(function (tab) {
            if (tab.getAttribute("data-ti-initialized") === "1") {
                return;
            }

            tab.addEventListener('shown.bs.tab', createCountUp);

            tab.setAttribute("data-ti-initialized", "1");
        });

        countUpInitialized = true;
    }

    var createTinySliders = function () {
        if (typeof tns === 'undefined') {
            return;
        }

        // Sliders
        const elements = Array.prototype.slice.call(document.querySelectorAll('[data-tns="true"]'), 0);

        if (!elements && elements.length === 0) {
            return;
        }

        elements.forEach(function (el) {
            if (el.getAttribute("data-ti-initialized") === "1") {
                return;
            }

            initTinySlider(el);

            el.setAttribute("data-ti-initialized", "1");
        });
    }

    var initTinySlider = function (el) {
        if (!el) {
            return;
        }

        const tnsOptions = {};

        // Convert string boolean
        const checkBool = function (val) {
            if (val === 'true') {
                return true;
            }
            if (val === 'false') {
                return false;
            }
            return val;
        };

        // get extra options via data attributes
        el.getAttributeNames().forEach(function (attrName) {
            // more options; https://github.com/ganlanyuan/tiny-slider#options
            if ((/^data-tns-.*/g).test(attrName)) {
                let optionName = attrName.replace('data-tns-', '').toLowerCase().replace(/(?:[\s-])\w/g, function (match) {
                    return match.replace('-', '').toUpperCase();
                });

                if (attrName === 'data-tns-responsive') {
                    // fix string with a valid json
                    const jsonStr = el.getAttribute(attrName).replace(/(\w+:)|(\w+ :)/g, function (matched) {
                        return '"' + matched.substring(0, matched.length - 1) + '":';
                    });
                    try {
                        // convert json string to object
                        tnsOptions[optionName] = JSON.parse(jsonStr);
                    }
                    catch (e) {
                    }
                }
                else {
                    tnsOptions[optionName] = checkBool(el.getAttribute(attrName));
                }
            }
        });

        const opt = Object.assign({}, {
            container: el,
            slideBy: 'page',
            autoplay: true,
            center: true,
            autoplayButtonOutput: false,
        }, tnsOptions);

        if (el.closest('.tns')) {
            TI_Util.addClass(el.closest('.tns'), 'tns-initiazlied');
        }

        return tns(opt);
    }

    var initSmoothScroll = function () {
        if (initialized === true) {
            return;
        }

        if (typeof SmoothScroll === 'undefined') {
            return;
        }

        new SmoothScroll('a[data-ti-scroll-toggle][href*="#"]', {
            speed: 1000,
            speedAsDuration: true,
            offset: function (anchor, toggle) {
                // Integer or Function returning an integer. How far to offset the scrolling anchor location in pixels
                // This example is a function, but you could do something as simple as `offset: 25`

                // An example returning different values based on whether the clicked link was in the header nav or not
                if (anchor.hasAttribute('data-ti-scroll-offset')) {
                    var val = TI_Util.getResponsiveValue(anchor.getAttribute('data-ti-scroll-offset'));

                    return val;
                } else {
                    return 0;
                }
            }
        });
    }

    var initCard = function() {
        // Toggle Handler
        TI_Util.on(document.body, '[data-ti-card-action="remove"]', 'click', function (e) {
            e.preventDefault();

            const card = this.closest('.card');

            if (!card) {
                return;
            }

            const confirmMessage = this.getAttribute("data-ti-card-confirm-message");
            const confirm = this.getAttribute("data-ti-card-confirm") === "true";

            if (confirm) {
                // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                Swal.fire({
                    text: confirmMessage ? confirmMessage : "Are you sure to remove ?",
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Confirm",
                    denyButtonText: "Cancel",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        denyButton: "btn btn-danger"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        card.remove();
                    }
                });
            } else {
                card.remove();
            }
        });
    }

    var initModal = function() {
        var elements = Array.prototype.slice.call(document.querySelectorAll("[data-bs-stacked-modal]"));

        if (elements && elements.length > 0) {
            elements.forEach((element) => {
                if (element.getAttribute("data-ti-initialized") === "1") {
                    return;
                }

                element.setAttribute("data-ti-initialized", "1");

                element.addEventListener("click", function(e) {
                    e.preventDefault();

                    const modalEl = document.querySelector(this.getAttribute("data-bs-stacked-modal"));

                    if (modalEl) {
                        const modal = new bootstrap.Modal(modalEl, {backdrop: false});
                        modal.show();
                    }
                });
            });
        }
    }

    var initCheck = function () {
        if (initialized === true) {
            return;
        }

        // Toggle Handler
        TI_Util.on(document.body, '[data-ti-check="true"]', 'change', function (e) {
            var check = this;
            var targets = document.querySelectorAll(check.getAttribute('data-ti-check-target'));

            TI_Util.each(targets, function (target) {
                if (target.type == 'checkbox') {
                    target.checked = check.checked;
                } else {
                    target.classList.toggle('active');
                }
            });
        });
    }

    var initBootstrapCollapse = function() {
        if (initialized === true) {
            return;
        }

        TI_Util.on(document.body,  '.collapsible[data-bs-toggle="collapse"]', 'click', function(e) {
            if (this.classList.contains('collapsed')) {
                this.classList.remove('active');
                this.blur();
            } else {
                this.classList.add('active');
            }

            if (this.hasAttribute('data-ti-toggle-text')) {
                var text = this.getAttribute('data-ti-toggle-text');
                var target = this.querySelector('[data-ti-toggle-text-target="true"]');
                var target = target ? target : this;

                this.setAttribute('data-ti-toggle-text', target.innerText);
                target.innerText = text;
            }
        });
    }

    var initBootstrapRotate = function() {
        if (initialized === true) {
            return;
        }

        TI_Util.on(document.body,  '[data-ti-rotate="true"]', 'click', function(e) {
            if (this.classList.contains('active')) {
                this.classList.remove('active');
                this.blur();
            } else {
                this.classList.add('active');
            }
        });
    }

    var initLozad = function() {
        // Check if lozad included
        if (typeof lozad === 'undefined') {
            return;
        }

		const observer = lozad(); // lazy loads elements with default selector as '.lozad'
        observer.observe();
	}

    var showPageLoading = function() {
        document.body.classList.add('page-loading');
        document.body.setAttribute('data-ti-app-page-loading', "on");
    }

    var hidePageLoading = function() {
        // CSS3 Transitions only after page load(.page-loading or .app-page-loading class added to body tag and remove with JS on page load)
        document.body.classList.remove('page-loading');
        document.body.removeAttribute('data-ti-app-page-loading');
    }

    var initShowHidePassword = function() {
        document.querySelectorAll('[data-ti-password-toggle="true"]').forEach(function (el) {
            el.addEventListener('click', function() {
                var input = el.previousElementSibling;

                if (input) {
                    if (input.type === 'password') {
                        input.type = 'text';
                        el.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    } else {
                        input.type = 'password';
                        el.innerHTML = '<i class="fas fa-eye"></i>';
                    }
                }
            });
        });
    }

    var initProvinceDistrictWard = function() {
        // Check if jQuery included
        if (typeof jQuery == 'undefined') {
            return;
        }

        // Check if select2 included
        if (typeof $.fn.select2 === 'undefined') {
            return;
        }
        // Province
        var elements = [].slice.call(document.querySelectorAll('[data-ti-province="true"]'));

        function searchVietnameseWithoutAccents(params, data) {
            if (!params.term) {
                return data;
            }
            if (params.term.trim() === '') {
                return data;
            }
            if (typeof data.text === 'undefined') {
                return null;
            }
            String.prototype.removeVietnameseAccents = removeVietnameseAccents;
            // Remove vietnamese accents
            if (data.text.removeVietnameseAccents().toUpperCase().indexOf(params.term.removeVietnameseAccents().toUpperCase()) > -1) {
                return data;
            }

            return null;
        }
        $.ajax({
            // url: "https://vapi.vnappmob.com/api/province/",
            dataType: "json",
            success: function(response) {
                var provinces = response.results;
                elements.map(function (element) {
                    if (element.getAttribute("data-ti-initialized") === "1") {
                        return;
                    }

                    var province_options = {
                        dir: document.body.getAttribute('direction'),
                        // minimumResultsForSearch: Infinity,
                        data: provinces.map(function (province) {
                            return {
                                id: province.province_id,
                                text: province.province_name
                            }
                        }),
                        matcher: searchVietnameseWithoutAccents
                        // templateResult: formatProvince,
                        // templateSelection: formatProvinceSelection
                    };

                    // if (element.getAttribute('data-hide-search') == 'true') {
                    //     options.minimumResultsForSearch = Infinity;
                    // }

                    $(element).select2(province_options);


                    element.setAttribute("data-ti-initialized", "1");

                    $(element).on('select2:select', function (e) {
                        var district_element = '#' + $(this).data('ti-district-select');
                        var ward_element = '#' + $(this).data('ti-ward-select');
                        if (district_element) {
                            $.ajax({
                                url: "https://vapi.vnappmob.com/api/province/district/" + e.params.data.id,
                                dataType: "json",
                                success: function (response) {
                                    var districts = response.results;
                                    if ($(district_element).data("ti-initialized") === "1") {
                                        $(district_element).data("ti-initialized", false);
                                        $(district_element).select2('destroy');
                                        $(district_element).empty();
                                    }
                                    if ($(ward_element).data("ti-initialized") === "1") {
                                        $(ward_element).data("ti-initialized", false);
                                        $(ward_element).select2('destroy');
                                        $(ward_element).empty();
                                    }
                                    // Add new options
                                    $(district_element).select2({
                                        dir: document.body.getAttribute('direction'),
                                        data: districts.map(function (district) {
                                            return {
                                                id: district.district_id,
                                                text: district.district_name
                                            }
                                        }),
                                        matcher: searchVietnameseWithoutAccents
                                    });

                                    $(district_element).data('ti-initialized', '1');

                                    // Init ward
                                    $(district_element).on('select2:select', function (e) {
                                        var district_id = e.params.data.id;
                                        $.ajax({
                                            url: "https://vapi.vnappmob.com/api/province/ward/" + district_id,
                                            dataType: "json",
                                            success: function (response) {
                                                var wards = response.results;
                                                if ($(ward_element).data("ti-initialized") === "1") {
                                                    $(ward_element).data("ti-initialized", false);
                                                    $(ward_element).select2('destroy');
                                                    $(ward_element).empty();
                                                }

                                                // Add new options
                                                $(ward_element).select2({
                                                    dir: document.body.getAttribute('direction'),
                                                    data: wards.map(function (ward) {
                                                        return {
                                                            id: ward.ward_id,
                                                            text: ward.ward_name
                                                        }
                                                    }),
                                                    matcher: searchVietnameseWithoutAccents
                                                });

                                                $(ward_element).data('ti-initialized', '1');
                                            }
                                        })
                                    });
                                }
                            });
                        }
                    });
                });
            }
        })



        /*
        * Hacky fix for a bug in select2 with jQuery 3.6.0's new nested-focus "protection"
        * see: https://github.com/select2/select2/issues/5993
        * see: https://github.com/jquery/jquery/issues/4382
        *
        * TODO: Recheck with the select2 GH issue and remove once this is fixed on their side
        */

        if (select2FocusFixInitialized === false) {
            select2FocusFixInitialized = true;

            $(document).on('select2:open', function(e) {
                var elements = document.querySelectorAll('.select2-container--open .select2-search__field');
                if (elements.length > 0) {
                    elements[elements.length - 1].focus();
                }
            });
        }
    }
    return {
        init: function () {
            initLozad();

            initSmoothScroll();

            initCard();

            initModal();

            initCheck();

            initShowHidePassword();

            selectAllRows();

            initBootstrapCollapse();

            initBootstrapRotate();

            createBootstrapTooltips();

            createBootstrapPopovers();

            createBootstrapToasts();

            createDateRangePickers();

            createButtons();

            createSelect2();

            initProvinceDistrictWard();

            createCountUp();

            createCountUpTabs();

            createAutosize();

            createTinySliders();

            initialized = true;
        },

        initTinySlider: function(el) {
            initTinySlider(el);
        },

        showPageLoading: function () {
            showPageLoading();
        },

        hidePageLoading: function () {
            hidePageLoading();
        },

        createBootstrapPopover: function(el, options) {
            return createBootstrapPopover(el, options);
        },

        createBootstrapTooltip: function(el, options) {
            return createBootstrapTooltip(el, options);
        }
    };
}();

// Declare TI_App for Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_App;
}
"use strict";

// Class definition
var TI_BlockUI = function(element, options) {
    //////////////////////////////
    // ** Private variables  ** //
    //////////////////////////////
    var the = this;

    if ( typeof element === "undefined" || element === null ) {
        return;
    }

    // Default options
    var defaultOptions = {
        zIndex: false,
        overlayClass: '',
        overflow: 'hidden',
        message: '<span class="spinner-border text-primary"></span>'
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        if ( TI_Util.data(element).has('blockui') ) {
            the = TI_Util.data(element).get('blockui');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.element = element;
        the.overlayElement = null;
        the.blocked = false;
        the.positionChanged = false;
        the.overflowChanged = false;

        // Bind Instance
        TI_Util.data(the.element).set('blockui', the);
    }

    var _block = function() {
        if ( TI_EventHandler.trigger(the.element, 'ti.blockui.block', the) === false ) {
            return;
        }

        var isPage = (the.element.tagName === 'BODY');

        var position = TI_Util.css(the.element, 'position');
        var overflow = TI_Util.css(the.element, 'overflow');
        var zIndex = isPage ? 10000 : 1;

        if (the.options.zIndex > 0) {
            zIndex = the.options.zIndex;
        } else {
            if (TI_Util.css(the.element, 'z-index') != 'auto') {
                zIndex = TI_Util.css(the.element, 'z-index');
            }
        }

        the.element.classList.add('blockui');

        if (position === "absolute" || position === "relative" || position === "fixed") {
            TI_Util.css(the.element, 'position', 'relative');
            the.positionChanged = true;
        }

        if (the.options.overflow === 'hidden' && overflow === 'visible') {
            TI_Util.css(the.element, 'overflow', 'hidden');
            the.overflowChanged = true;
        }

        the.overlayElement = document.createElement('DIV');
        the.overlayElement.setAttribute('class', 'blockui-overlay ' + the.options.overlayClass);

        the.overlayElement.innerHTML = the.options.message;

        TI_Util.css(the.overlayElement, 'z-index', zIndex);

        the.element.append(the.overlayElement);
        the.blocked = true;

        TI_EventHandler.trigger(the.element, 'ti.blockui.after.blocked', the)
    }

    var _release = function() {
        if ( TI_EventHandler.trigger(the.element, 'ti.blockui.release', the) === false ) {
            return;
        }

        the.element.classList.add('blockui');

        if (the.positionChanged) {
            TI_Util.css(the.element, 'position', '');
        }

        if (the.overflowChanged) {
            TI_Util.css(the.element, 'overflow', '');
        }

        if (the.overlayElement) {
            TI_Util.remove(the.overlayElement);
        }

        the.blocked = false;

        TI_EventHandler.trigger(the.element, 'ti.blockui.released', the);
    }

    var _isBlocked = function() {
        return the.blocked;
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('blockui');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.block = function() {
        _block();
    }

    the.release = function() {
        _release();
    }

    the.isBlocked = function() {
        return _isBlocked();
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return TI_EventHandler.trigger(the.element, name, event, the, event);
    }
};

// Static methods
TI_BlockUI.getInstance = function(element) {
    if (element !== null && TI_Util.data(element).has('blockui')) {
        return TI_Util.data(element).get('blockui');
    } else {
        return null;
    }
}

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_BlockUI;
}
"use strict";
// DOCS: https://javascript.info/cookie

// Class definition
var TI_Cookie = function() {
    return {
        // returns the cookie with the given name,
        // or undefined if not found
        get: function(name) {
            var matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));

            return matches ? decodeURIComponent(matches[1]) : null;
        },

        // Please note that a cookie value is encoded,
        // so getCookie uses a built-in decodeURIComponent function to decode it.
        set: function(name, value, options) {
            if ( typeof options === "undefined" || options === null ) {
                options = {};
            }

            options = Object.assign({}, {
                path: '/'
            }, options);

            if ( options.expires instanceof Date ) {
                options.expires = options.expires.toUTCString();
            }

            var updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

            for ( var optionKey in options ) {
                if ( options.hasOwnProperty(optionKey) === false ) {
                    continue;
                }

                updatedCookie += "; " + optionKey;
                var optionValue = options[optionKey];

                if ( optionValue !== true ) {
                    updatedCookie += "=" + optionValue;
                }
            }

            document.cookie = updatedCookie;
        },

        // To remove a cookie, we can call it with a negative expiration date:
        remove: function(name) {
            this.set(name, "", {
                'max-age': -1
            });
        }
    }
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Cookie;
}

"use strict";

// Class definition
var TI_Dialer = function(element, options) {
    ////////////////////////////
    // ** Private variables  ** //
    ////////////////////////////
    var the = this;

    if (!element) {
        return;
    }

    // Default options
    var defaultOptions = {
        min: null,
        max: null,
        step: 1,
        decimals: 0,
        prefix: "",
        suffix: ""
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    // Constructor
    var _construct = function() {
        if ( TI_Util.data(element).has('dialer') === true ) {
            the = TI_Util.data(element).get('dialer');
        } else {
            _init();
        }
    }

    // Initialize
    var _init = function() {
        // Variables
        the.options = TI_Util.deepExtend({}, defaultOptions, options);

        // Elements
        the.element = element;
        the.incElement = the.element.querySelector('[data-ti-dialer-control="increase"]');
        the.decElement = the.element.querySelector('[data-ti-dialer-control="decrease"]');
        the.inputElement = the.element.querySelector('input[type]');

        // Set Values
        if (_getOption('decimals')) {
            the.options.decimals = parseInt(_getOption('decimals'));
        }

        if (_getOption('prefix')) {
            the.options.prefix = _getOption('prefix');
        }

        if (_getOption('suffix')) {
            the.options.suffix = _getOption('suffix');
        }

        if (_getOption('step')) {
            the.options.step = parseFloat(_getOption('step'));
        }

        if (_getOption('min')) {
            the.options.min = parseFloat(_getOption('min'));
        }

        if (_getOption('max')) {
            the.options.max = parseFloat(_getOption('max'));
        }

        the.value = parseFloat(the.inputElement.value.replace(/[^\d.]/g, ''));

        _setValue();

        // Event Handlers
        _handlers();

        // Bind Instance
        TI_Util.data(the.element).set('dialer', the);
    }

    // Handlers
    var _handlers = function() {
        TI_Util.addEvent(the.incElement, 'click', function(e) {
            e.preventDefault();

            _increase();
        });

        TI_Util.addEvent(the.decElement, 'click', function(e) {
            e.preventDefault();

            _decrease();
        });

        TI_Util.addEvent(the.inputElement, 'input', function(e) {
            e.preventDefault();

            _setValue();
        });
    }

    // Event handlers
    var _increase = function() {
        // Trigger "after.dialer" event
        TI_EventHandler.trigger(the.element, 'ti.dialer.increase', the);

        the.inputElement.value = the.value + the.options.step;
        _setValue();

        // Trigger "before.dialer" event
        TI_EventHandler.trigger(the.element, 'ti.dialer.increased', the);

        return the;
    }

    var _decrease = function() {
        // Trigger "after.dialer" event
        TI_EventHandler.trigger(the.element, 'ti.dialer.decrease', the);

        the.inputElement.value = the.value - the.options.step;

        _setValue();

        // Trigger "before.dialer" event
        TI_EventHandler.trigger(the.element, 'ti.dialer.decreased', the);

        return the;
    }

    // Set Input Value
    var _setValue = function(value) {
        // Trigger "after.dialer" event
        TI_EventHandler.trigger(the.element, 'ti.dialer.change', the);

        if (value !== undefined) {
            the.value = value;
        } else {
            the.value = _parse(the.inputElement.value);
        }

        if (the.options.min !== null && the.value < the.options.min) {
            the.value = the.options.min;
        }

        if (the.options.max !== null && the.value > the.options.max) {
            the.value = the.options.max;
        }

        the.inputElement.value = _format(the.value);

        // Trigger input change event
        the.inputElement.dispatchEvent(new Event('change'));

        // Trigger "after.dialer" event
        TI_EventHandler.trigger(the.element, 'ti.dialer.changed', the);
    }

    var _parse = function(val) {
        val = val
            .replace(/[^0-9.-]/g, '')       // remove chars except number, hyphen, point.
            .replace(/(\..*)\./g, '$1')     // remove multiple points.
            .replace(/(?!^)-/g, '')         // remove middle hyphen.
            .replace(/^0+(\d)/gm, '$1');    // remove multiple leading zeros. <-- I added this.

        val = parseFloat(val);

        if (isNaN(val)) {
            val = 0;
        }

        return val;
    }

    // Format
    var _format = function(val){
        return the.options.prefix + parseFloat(val).toFixed(the.options.decimals) + the.options.suffix;
    }

    // Get option
    var _getOption = function(name) {
        if ( the.element.hasAttribute('data-ti-dialer-' + name) === true ) {
            var attr = the.element.getAttribute('data-ti-dialer-' + name);
            var value = attr;

            return value;
        } else {
            return null;
        }
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('dialer');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.setMinValue = function(value) {
        the.options.min = value;
    }

    the.setMaxValue = function(value) {
        the.options.max = value;
    }

    the.setValue = function(value) {
        _setValue(value);
    }

    the.getValue = function() {
        return the.inputElement.value;
    }

    the.update = function() {
        _setValue();
    }

    the.increase = function() {
        return _increase();
    }

    the.decrease = function() {
        return _decrease();
    }

    the.getElement = function() {
        return the.element;
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return TI_EventHandler.trigger(the.element, name, event, the, event);
    }
};

// Static methods
TI_Dialer.getInstance = function(element) {
    if ( element !== null && TI_Util.data(element).has('dialer') ) {
        return TI_Util.data(element).get('dialer');
    } else {
        return null;
    }
}

// Create instances
TI_Dialer.createInstances = function(selector = '[data-ti-dialer="true"]') {
    // Get instances
    var elements = document.querySelectorAll(selector);

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            new TI_Dialer(elements[i]);
        }
    }
}

// Global initialization
TI_Dialer.init = function() {
    TI_Dialer.createInstances();
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Dialer;
}
"use strict";

var TI_DrawerHandlersInitialized = false;

// Class definition
var TI_Drawer = function(element, options) {
    //////////////////////////////
    // ** Private variables  ** //
    //////////////////////////////
    var the = this;

    if ( typeof element === "undefined" || element === null ) {
        return;
    }

    // Default options
    var defaultOptions = {
        overlay: true,
        direction: 'end',
        baseClass: 'drawer',
        overlayClass: 'drawer-overlay'
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        if ( TI_Util.data(element).has('drawer') ) {
            the = TI_Util.data(element).get('drawer');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.uid = TI_Util.getUniqueId('drawer');
        the.element = element;
        the.overlayElement = null;
        the.name = the.element.getAttribute('data-ti-drawer-name');
        the.shown = false;
        the.lastWidth;
        the.toggleElement = null;

        // Set initialized
        the.element.setAttribute('data-ti-drawer', 'true');

        // Event Handlers
        _handlers();

        // Update Instance
        _update();

        // Bind Instance
        TI_Util.data(the.element).set('drawer', the);
    }

    var _handlers = function() {
        var togglers = _getOption('toggle');
        var closers = _getOption('close');

        if ( togglers !== null && togglers.length > 0 ) {
            TI_Util.on(document.body, togglers, 'click', function(e) {
                e.preventDefault();

                the.toggleElement = this;
                _toggle();
            });
        }

        if ( closers !== null && closers.length > 0 ) {
            TI_Util.on(document.body, closers, 'click', function(e) {
                e.preventDefault();

                the.closeElement = this;
                _hide();
            });
        }
    }

    var _toggle = function() {
        if ( TI_EventHandler.trigger(the.element, 'ti.drawer.toggle', the) === false ) {
            return;
        }

        if ( the.shown === true ) {
            _hide();
        } else {
            _show();
        }

        TI_EventHandler.trigger(the.element, 'ti.drawer.toggled', the);
    }

    var _hide = function() {
        if ( TI_EventHandler.trigger(the.element, 'ti.drawer.hide', the) === false ) {
            return;
        }

        the.shown = false;

        _deleteOverlay();

        document.body.removeAttribute('data-ti-drawer-' + the.name, 'on');
        document.body.removeAttribute('data-ti-drawer');

        TI_Util.removeClass(the.element, the.options.baseClass + '-on');

        if ( the.toggleElement !== null ) {
            TI_Util.removeClass(the.toggleElement, 'active');
        }

        TI_EventHandler.trigger(the.element, 'ti.drawer.after.hidden', the) === false
    }

    var _show = function() {
        if ( TI_EventHandler.trigger(the.element, 'ti.drawer.show', the) === false ) {
            return;
        }

        the.shown = true;

        _createOverlay();
        document.body.setAttribute('data-ti-drawer-' + the.name, 'on');
        document.body.setAttribute('data-ti-drawer', 'on');

        TI_Util.addClass(the.element, the.options.baseClass + '-on');

        if ( the.toggleElement !== null ) {
            TI_Util.addClass(the.toggleElement, 'active');
        }

        TI_EventHandler.trigger(the.element, 'ti.drawer.shown', the);
    }

    var _update = function() {
        var width = _getWidth();
        var direction = _getOption('direction');

        var top = _getOption('top');
        var bottom = _getOption('bottom');
        var start = _getOption('start');
        var end = _getOption('end');

        // Reset state
        if ( TI_Util.hasClass(the.element, the.options.baseClass + '-on') === true && String(document.body.getAttribute('data-ti-drawer-' + the.name + '-')) === 'on' ) {
            the.shown = true;
        } else {
            the.shown = false;
        }

        // Activate/deactivate
        if ( _getOption('activate') === true ) {
            TI_Util.addClass(the.element, the.options.baseClass);
            TI_Util.addClass(the.element, the.options.baseClass + '-' + direction);

            TI_Util.css(the.element, 'width', width, true);
            the.lastWidth = width;

            if (top) {
                TI_Util.css(the.element, 'top', top);
            }

            if (bottom) {
                TI_Util.css(the.element, 'bottom', bottom);
            }

            if (start) {
                if (TI_Util.isRTL()) {
                    TI_Util.css(the.element, 'right', start);
                } else {
                    TI_Util.css(the.element, 'left', start);
                }
            }

            if (end) {
                if (TI_Util.isRTL()) {
                    TI_Util.css(the.element, 'left', end);
                } else {
                    TI_Util.css(the.element, 'right', end);
                }
            }
        } else {
            TI_Util.removeClass(the.element, the.options.baseClass);
            TI_Util.removeClass(the.element, the.options.baseClass + '-' + direction);

            TI_Util.css(the.element, 'width', '');

            if (top) {
                TI_Util.css(the.element, 'top', '');
            }

            if (bottom) {
                TI_Util.css(the.element, 'bottom', '');
            }

            if (start) {
                if (TI_Util.isRTL()) {
                    TI_Util.css(the.element, 'right', '');
                } else {
                    TI_Util.css(the.element, 'left', '');
                }
            }

            if (end) {
                if (TI_Util.isRTL()) {
                    TI_Util.css(the.element, 'left', '');
                } else {
                    TI_Util.css(the.element, 'right', '');
                }
            }

            _hide();
        }
    }

    var _createOverlay = function() {
        if ( _getOption('overlay') === true ) {
            the.overlayElement = document.createElement('DIV');

            TI_Util.css(the.overlayElement, 'z-index', TI_Util.css(the.element, 'z-index') - 1); // update

            document.body.append(the.overlayElement);

            TI_Util.addClass(the.overlayElement, _getOption('overlay-class'));

            TI_Util.addEvent(the.overlayElement, 'click', function(e) {
                e.preventDefault();

                if ( _getOption('permanent') !== true ) {
                    _hide();
                }
            });
        }
    }

    var _deleteOverlay = function() {
        if ( the.overlayElement !== null ) {
            TI_Util.remove(the.overlayElement);
        }
    }

    var _getOption = function(name) {
        if ( the.element.hasAttribute('data-ti-drawer-' + name) === true ) {
            var attr = the.element.getAttribute('data-ti-drawer-' + name);
            var value = TI_Util.getResponsiveValue(attr);

            if ( value !== null && String(value) === 'true' ) {
                value = true;
            } else if ( value !== null && String(value) === 'false' ) {
                value = false;
            }

            return value;
        } else {
            var optionName = TI_Util.snakeToCamel(name);

            if ( the.options[optionName] ) {
                return TI_Util.getResponsiveValue(the.options[optionName]);
            } else {
                return null;
            }
        }
    }

    var _getWidth = function() {
        var width = _getOption('width');

        if ( width === 'auto') {
            width = TI_Util.css(the.element, 'width');
        }

        return width;
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('drawer');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.toggle = function() {
        return _toggle();
    }

    the.show = function() {
        return _show();
    }

    the.hide = function() {
        return _hide();
    }

    the.isShown = function() {
        return the.shown;
    }

    the.update = function() {
        _update();
    }

    the.goElement = function() {
        return the.element;
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return TI_EventHandler.trigger(the.element, name, event, the, event);
    }
};

// Static methods
TI_Drawer.getInstance = function(element) {
    if (element !== null && TI_Util.data(element).has('drawer')) {
        return TI_Util.data(element).get('drawer');
    } else {
        return null;
    }
}

// Hide all drawers and skip one if provided
TI_Drawer.hideAll = function(skip = null, selector = '[data-ti-drawer="true"]') {
    var items = document.querySelectorAll(selector);

    if (items && items.length > 0) {
        for (var i = 0, len = items.length; i < len; i++) {
            var item = items[i];
            var drawer = TI_Drawer.getInstance(item);

            if (!drawer) {
                continue;
            }

            if ( skip ) {
                if ( item !== skip ) {
                    drawer.hide();
                }
            } else {
                drawer.hide();
            }
        }
    }
}

// Update all drawers
TI_Drawer.updateAll = function(selector = '[data-ti-drawer="true"]') {
    var items = document.querySelectorAll(selector);

    if (items && items.length > 0) {
        for (var i = 0, len = items.length; i < len; i++) {
            var drawer = TI_Drawer.getInstance(items[i]);

            if (drawer) {
                drawer.update();
            }
        }
    }
}

// Create instances
TI_Drawer.createInstances = function(selector = '[data-ti-drawer="true"]') {
    // Initialize Menus
    var elements = document.querySelectorAll(selector);

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            new TI_Drawer(elements[i]);
        }
    }
}

// Toggle instances
TI_Drawer.handleShow = function() {
    // External drawer toggle handler
    TI_Util.on(document.body,  '[data-ti-drawer-show="true"][data-ti-drawer-target]', 'click', function(e) {
        e.preventDefault();

        var element = document.querySelector(this.getAttribute('data-ti-drawer-target'));

        if (element) {
            TI_Drawer.getInstance(element).show();
        }
    });
}

// Dismiss instances
TI_Drawer.handleDismiss = function() {
    // External drawer toggle handler
    TI_Util.on(document.body,  '[data-ti-drawer-dismiss="true"]', 'click', function(e) {
        var element = this.closest('[data-ti-drawer="true"]');

        if (element) {
            var drawer = TI_Drawer.getInstance(element);
            if (drawer.isShown()) {
                drawer.hide();
            }
        }
    });
}

// Handle resize
TI_Drawer.handleResize = function() {
    // Window resize Handling
    window.addEventListener('resize', function() {
        var timer;

        TI_Util.throttle(timer, function() {
            // Locate and update drawer instances on window resize
            var elements = document.querySelectorAll('[data-ti-drawer="true"]');

            if ( elements && elements.length > 0 ) {
                for (var i = 0, len = elements.length; i < len; i++) {
                    var drawer = TI_Drawer.getInstance(elements[i]);
                    if (drawer) {
                        drawer.update();
                    }
                }
            }
        }, 200);
    });
}

// Global initialization
TI_Drawer.init = function() {
    TI_Drawer.createInstances();

    if (TI_DrawerHandlersInitialized === false) {
        TI_Drawer.handleResize();
        TI_Drawer.handleShow();
        TI_Drawer.handleDismiss();

        TI_DrawerHandlersInitialized = true;
    }
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Drawer;
}
"use strict";

// Class definition
var TI_EventHandler = function() {
    ////////////////////////////
    // ** Private Variables  ** //
    ////////////////////////////
    var _handlers = {};

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////
    var _triggerEvent = function(element, name, target) {
        var returnValue = true;
        var eventValue;

        if ( TI_Util.data(element).has(name) === true ) {
            var handlerIds = TI_Util.data(element).get(name);
            var handlerId;

            for (var i = 0; i < handlerIds.length; i++) {
                handlerId = handlerIds[i];

                if ( _handlers[name] && _handlers[name][handlerId] ) {
                    var handler = _handlers[name][handlerId];
                    var value;

                    if ( handler.name === name ) {
                        if ( handler.one == true ) {
                            if ( handler.fired == false ) {
                                _handlers[name][handlerId].fired = true;

                                eventValue = handler.callback.call(this, target);
                            }
                        } else {
                            eventValue = handler.callback.call(this, target);
                        }

                        if ( eventValue === false ) {
                            returnValue = false;
                        }
                    }
                }
            }
        }

        return returnValue;
    }

    var _addEvent = function(element, name, callback, one) {
        var handlerId = TI_Util.getUniqueId('event');
        var handlerIds = TI_Util.data(element).get(name);

        if ( !handlerIds ) {
            handlerIds = [];
        }

        handlerIds.push(handlerId);

        TI_Util.data(element).set(name, handlerIds);

        if ( !_handlers[name] ) {
            _handlers[name] = {};
        }

        _handlers[name][handlerId] = {
            name: name,
            callback: callback,
            one: one,
            fired: false
        };

        return handlerId;
    }

    var _removeEvent = function(element, name, handlerId) {
        var handlerIds = TI_Util.data(element).get(name);
        var index = handlerIds && handlerIds.indexOf(handlerId);

        if (index !== -1) {
            handlerIds.splice(index, 1);
            TI_Util.data(element).set(name, handlerIds);
        }

        if (_handlers[name] && _handlers[name][handlerId]) {
            delete _handlers[name][handlerId];
        }
    }

    ////////////////////////////
    // ** Public Methods  ** //
    ////////////////////////////
    return {
        trigger: function(element, name, target) {
            return _triggerEvent(element, name, target);
        },

        on: function(element, name, handler) {
            return _addEvent(element, name, handler);
        },

        one: function(element, name, handler) {
            return _addEvent(element, name, handler, true);
        },

        off: function(element, name, handlerId) {
            return _removeEvent(element, name, handlerId);
        },

        debug: function() {
            for (var b in _handlers) {
                if ( _handlers.hasOwnProperty(b) ) console.log(b);
            }
        }
    }
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_EventHandler;
}

"use strict";

// Class definition
var TI_Feedback = function(options) {
    ////////////////////////////
    // ** Private Variables  ** //
    ////////////////////////////
    var the = this;

    // Default options
    var defaultOptions = {
        'width' : 100,
        'placement' : 'top-center',
        'content' : '',
        'type': 'popup'
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        _init();
    }

    var _init = function() {
        // Variables
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.uid = TI_Util.getUniqueId('feedback');
        the.element;
        the.shown = false;

        // Event Handlers
        _handlers();

        // Bind Instance
        TI_Util.data(the.element).set('feedback', the);
    }

    var _handlers = function() {
        TI_Util.addEvent(the.element, 'click', function(e) {
            e.preventDefault();

            _go();
        });
    }

    var _show = function() {
        if ( TI_EventHandler.trigger(the.element, 'ti.feedback.show', the) === false ) {
            return;
        }

        if ( the.options.type === 'popup') {
            _showPopup();
        }

        TI_EventHandler.trigger(the.element, 'ti.feedback.shown', the);

        return the;
    }

    var _hide = function() {
        if ( TI_EventHandler.trigger(the.element, 'ti.feedback.hide', the) === false ) {
            return;
        }

        if ( the.options.type === 'popup') {
            _hidePopup();
        }

        the.shown = false;

        TI_EventHandler.trigger(the.element, 'ti.feedback.hidden', the);

        return the;
    }

    var _showPopup = function() {
        the.element = document.createElement("DIV");

        TI_Util.addClass(the.element, 'feedback feedback-popup');
        TI_Util.setHTML(the.element, the.options.content);

        if (the.options.placement == 'top-center') {
            _setPopupTopCenterPosition();
        }

        document.body.appendChild(the.element);

        TI_Util.addClass(the.element, 'feedback-shown');

        the.shown = true;
    }

    var _setPopupTopCenterPosition = function() {
        var width = TI_Util.getResponsiveValue(the.options.width);
        var height = TI_Util.css(the.element, 'height');

        TI_Util.addClass(the.element, 'feedback-top-center');

        TI_Util.css(the.element, 'width', width);
        TI_Util.css(the.element, 'left', '50%');
        TI_Util.css(the.element, 'top', '-' + height);
    }

    var _hidePopup = function() {
        the.element.remove();
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('feedback');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.show = function() {
        return _show();
    }

    the.hide = function() {
        return _hide();
    }

    the.isShown = function() {
        return the.shown;
    }

    the.getElement = function() {
        return the.element;
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return TI_EventHandler.trigger(the.element, name, event, the, event);
    }
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Feedback;
}

"use strict";

// Class definition
var TI_ImageInput = function(element, options) {
    ////////////////////////////
    // ** Private Variables  ** //
    ////////////////////////////
    var the = this;

    if ( typeof element === "undefined" || element === null ) {
        return;
    }

    // Default Options
    var defaultOptions = {

    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var _construct = function() {
        if ( TI_Util.data(element).has('image-input') === true ) {
            the = TI_Util.data(element).get('image-input');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.uid = TI_Util.getUniqueId('image-input');

        // Elements
        the.element = element;
        the.inputElement = TI_Util.find(element, 'input[type="file"]');
        the.wrapperElement = TI_Util.find(element, '.image-input-wrapper');
        the.cancelElement = TI_Util.find(element, '[data-ti-image-input-action="cancel"]');
        the.removeElement = TI_Util.find(element, '[data-ti-image-input-action="remove"]');
        the.hiddenElement = TI_Util.find(element, 'input[type="hidden"]');
        the.src = TI_Util.css(the.wrapperElement, 'backgroundImage');

        // Set initialized
        the.element.setAttribute('data-ti-image-input', 'true');

        // Event Handlers
        _handlers();

        // Bind Instance
        TI_Util.data(the.element).set('image-input', the);
    }

    // Init Event Handlers
    var _handlers = function() {
        TI_Util.addEvent(the.inputElement, 'change', _change);
        TI_Util.addEvent(the.cancelElement, 'click', _cancel);
        TI_Util.addEvent(the.removeElement, 'click', _remove);
    }

    // Event Handlers
    var _change = function(e) {
        e.preventDefault();

        if ( the.inputElement !== null && the.inputElement.files && the.inputElement.files[0] ) {
            // Fire change event
            if ( TI_EventHandler.trigger(the.element, 'ti.imageinput.change', the) === false ) {
                return;
            }

            var reader = new FileReader();

            reader.onload = function(e) {
                TI_Util.css(the.wrapperElement, 'background-image', 'url('+ e.target.result +')');
            }

            reader.readAsDataURL(the.inputElement.files[0]);

            the.element.classList.add('image-input-changed');
            the.element.classList.remove('image-input-empty');

            // Fire removed event
            TI_EventHandler.trigger(the.element, 'ti.imageinput.changed', the);
        }
    }

    var _cancel = function(e) {
        e.preventDefault();

        // Fire cancel event
        if ( TI_EventHandler.trigger(the.element, 'ti.imageinput.cancel', the) === false ) {
            return;
        }

        the.element.classList.remove('image-input-changed');
        the.element.classList.remove('image-input-empty');

        if (the.src === 'none') {
            TI_Util.css(the.wrapperElement, 'background-image', '');
            the.element.classList.add('image-input-empty');
        } else {
            TI_Util.css(the.wrapperElement, 'background-image', the.src);
        }

        the.inputElement.value = "";

        if ( the.hiddenElement !== null ) {
            the.hiddenElement.value = "0";
        }

        // Fire canceled event
        TI_EventHandler.trigger(the.element, 'ti.imageinput.canceled', the);
    }

    var _remove = function(e) {
        e.preventDefault();

        // Fire remove event
        if ( TI_EventHandler.trigger(the.element, 'ti.imageinput.remove', the) === false ) {
            return;
        }

        the.element.classList.remove('image-input-changed');
        the.element.classList.add('image-input-empty');

        TI_Util.css(the.wrapperElement, 'background-image', "none");
        the.inputElement.value = "";

        if ( the.hiddenElement !== null ) {
            the.hiddenElement.value = "1";
        }

        // Fire removed event
        TI_EventHandler.trigger(the.element, 'ti.imageinput.removed', the);
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('image-input');
    }

    // Construct Class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.getInputElement = function() {
        return the.inputElement;
    }

    the.getElement = function() {
        return the.element;
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return TI_EventHandler.trigger(the.element, name, event, the, event);
    }
};

// Static methods
TI_ImageInput.getInstance = function(element) {
    if ( element !== null && TI_Util.data(element).has('image-input') ) {
        return TI_Util.data(element).get('image-input');
    } else {
        return null;
    }
}

// Create instances
TI_ImageInput.createInstances = function(selector = '[data-ti-image-input]') {
    // Initialize Menus
    var elements = document.querySelectorAll(selector);

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            new TI_ImageInput(elements[i]);
        }
    }
}

// Global initialization
TI_ImageInput.init = function() {
    TI_ImageInput.createInstances();
};

// Webpack Support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_ImageInput;
}

"use strict";

var TI_MenuHandlersInitialized = false;

// Class definition
var TI_Menu = function(element, options) {
    ////////////////////////////
    // ** Private Variables  ** //
    ////////////////////////////
    var the = this;

    if ( typeof element === "undefined" || element === null ) {
        return;
    }

    // Default Options
    var defaultOptions = {
        dropdown: {
            hoverTimeout: 200,
            zindex: 107
        },

        accordion: {
            slideSpeed: 250,
            expand: false
        }
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var _construct = function() {
        if ( TI_Util.data(element).has('menu') === true ) {
            the = TI_Util.data(element).get('menu');
        } else {
            _init();
        }
    }

    var _init = function() {
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.uid = TI_Util.getUniqueId('menu');
        the.element = element;
        the.triggerElement;
        the.disabled = false;

        // Set initialized
        the.element.setAttribute('data-ti-menu', 'true');

        _setTriggerElement();
        _update();

        TI_Util.data(the.element).set('menu', the);
    }

    var _destroy = function() {  // todo

    }

    // Event Handlers
    // Toggle handler
    var _click = function(element, e) {
        e.preventDefault();

        if (the.disabled === true) {
            return;
        }

        var item = _getItemElement(element);

        if ( _getOptionFromElementAttribute(item, 'trigger') !== 'click' ) {
            return;
        }

        if ( _getOptionFromElementAttribute(item, 'toggle') === false ) {
            _show(item);
        } else {
            _toggle(item);
        }
    }

    // Link handler
    var _link = function(element, e) {
        if (the.disabled === true) {
            return;
        }

        if ( TI_EventHandler.trigger(the.element, 'ti.menu.link.click', element) === false )  {
            return;
        }

        // Dismiss all shown dropdowns
        TI_Menu.hideDropdowns();

        TI_EventHandler.trigger(the.element, 'ti.menu.link.clicked', element);
    }

    // Dismiss handler
    var _dismiss = function(element, e) {
        var item = _getItemElement(element);
        var items = _getItemChildElements(item);

        if ( item !== null && _getItemSubType(item) === 'dropdown') {
            _hide(item); // hide items dropdown
            // Hide all child elements as well

            if ( items.length > 0 ) {
                for (var i = 0, len = items.length; i < len; i++) {
                    if ( items[i] !== null &&  _getItemSubType(items[i]) === 'dropdown') {
                        _hide(tems[i]);
                    }
                }
            }
        }
    }

    // Mouseover handle
    var _mouseover = function(element, e) {
        var item = _getItemElement(element);

        if (the.disabled === true) {
            return;
        }

        if ( item === null ) {
            return;
        }

        if ( _getOptionFromElementAttribute(item, 'trigger') !== 'hover' ) {
            return;
        }

        if ( TI_Util.data(item).get('hover') === '1' ) {
            clearTimeout(TI_Util.data(item).get('timeout'));
            TI_Util.data(item).remove('hover');
            TI_Util.data(item).remove('timeout');
        }

        _show(item);
    }

    // Mouseout handle
    var _mouseout = function(element, e) {
        var item = _getItemElement(element);

        if (the.disabled === true) {
            return;
        }

        if ( item === null ) {
            return;
        }

        if ( _getOptionFromElementAttribute(item, 'trigger') !== 'hover' ) {
            return;
        }

        var timeout = setTimeout(function() {
            if ( TI_Util.data(item).get('hover') === '1' ) {
                _hide(item);
            }
        }, the.options.dropdown.hoverTimeout);

        TI_Util.data(item).set('hover', '1');
        TI_Util.data(item).set('timeout', timeout);
    }

    // Toggle item sub
    var _toggle = function(item) {
        if ( !item ) {
            item = the.triggerElement;
        }

        if ( _isItemSubShown(item) === true ) {
            _hide(item);
        } else {
            _show(item);
        }
    }

    // Show item sub
    var _show = function(item) {
        if ( !item ) {
            item = the.triggerElement;
        }

        if ( _isItemSubShown(item) === true ) {
            return;
        }

        if ( _getItemSubType(item) === 'dropdown' ) {
            _showDropdown(item); // // show current dropdown
        } else if ( _getItemSubType(item) === 'accordion' ) {
            _showAccordion(item);
        }

        // Remember last submenu type
        TI_Util.data(item).set('type', _getItemSubType(item));  // updated
    }

    // Hide item sub
    var _hide = function(item) {
        if ( !item ) {
            item = the.triggerElement;
        }

        if ( _isItemSubShown(item) === false ) {
            return;
        }

        if ( _getItemSubType(item) === 'dropdown' ) {
            _hideDropdown(item);
        } else if ( _getItemSubType(item) === 'accordion' ) {
            _hideAccordion(item);
        }
    }

    // Reset item state classes if item sub type changed
    var _reset = function(item) {
        if ( _hasItemSub(item) === false ) {
            return;
        }

        var sub = _getItemSubElement(item);

        // Reset sub state if sub type is changed during the window resize
        if ( TI_Util.data(item).has('type') && TI_Util.data(item).get('type') !== _getItemSubType(item) ) {  // updated
            TI_Util.removeClass(item, 'hover');
            TI_Util.removeClass(item, 'show');
            TI_Util.removeClass(sub, 'show');
        }  // updated
    }

    // Update all item state classes if item sub type changed
    var _update = function() {
        var items = the.element.querySelectorAll('.menu-item[data-ti-menu-trigger]');

        if ( items && items.length > 0 ) {
            for (var i = 0, len = items.length; i < len; i++) {
                _reset(items[i]);
            }
        }
    }

    // Set external trigger element
    var _setTriggerElement = function() {
        var target = document.querySelector('[data-ti-menu-target="#' + the.element.getAttribute('id')  + '"]');

        if ( target !== null ) {
            the.triggerElement = target;
        } else if ( the.element.closest('[data-ti-menu-trigger]') ) {
            the.triggerElement = the.element.closest('[data-ti-menu-trigger]');
        } else if ( the.element.parentNode && TI_Util.child(the.element.parentNode, '[data-ti-menu-trigger]')) {
            the.triggerElement = TI_Util.child(the.element.parentNode, '[data-ti-menu-trigger]');
        }

        if ( the.triggerElement ) {
            TI_Util.data(the.triggerElement).set('menu', the);
        }
    }

    // Test if menu has external trigger element
    var _isTriggerElement = function(item) {
        return ( the.triggerElement === item ) ? true : false;
    }

    // Test if item's sub is shown
    var _isItemSubShown = function(item) {
        var sub = _getItemSubElement(item);

        if ( sub !== null ) {
            if ( _getItemSubType(item) === 'dropdown' ) {
                if ( TI_Util.hasClass(sub, 'show') === true && sub.hasAttribute('data-popper-placement') === true ) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return TI_Util.hasClass(item, 'show');
            }
        } else {
            return false;
        }
    }

    // Test if item dropdown is permanent
    var _isItemDropdownPermanent = function(item) {
        return _getOptionFromElementAttribute(item, 'permanent') === true ? true : false;
    }

    // Test if item's parent is shown
    var _isItemParentShown = function(item) {
        return TI_Util.parents(item, '.menu-item.show').length > 0;
    }

    // Test of it is item sub element
    var _isItemSubElement = function(item) {
        return TI_Util.hasClass(item, 'menu-sub');
    }

    // Test if item has sub
    var _hasItemSub = function(item) {
        return (TI_Util.hasClass(item, 'menu-item') && item.hasAttribute('data-ti-menu-trigger'));
    }

    // Get link element
    var _getItemLinkElement = function(item) {
        return TI_Util.child(item, '.menu-link');
    }

    // Get toggle element
    var _getItemToggleElement = function(item) {
        if ( the.triggerElement ) {
            return the.triggerElement;
        } else {
            return _getItemLinkElement(item);
        }
    }

    // Get item sub element
    var _getItemSubElement = function(item) {
        if ( _isTriggerElement(item) === true ) {
            return the.element;
        } if ( item.classList.contains('menu-sub') === true ) {
            return item;
        } else if ( TI_Util.data(item).has('sub') ) {
            return TI_Util.data(item).get('sub');
        } else {
            return TI_Util.child(item, '.menu-sub');
        }
    }

    // Get item sub type
    var _getItemSubType = function(element) {
        var sub = _getItemSubElement(element);

        if ( sub && parseInt(TI_Util.css(sub, 'z-index')) > 0 ) {
            return "dropdown";
        } else {
            return "accordion";
        }
    }

    // Get item element
    var _getItemElement = function(element) {
        var item, sub;

        // Element is the external trigger element
        if (_isTriggerElement(element) ) {
            return element;
        }

        // Element has item toggler attribute
        if ( element.hasAttribute('data-ti-menu-trigger') ) {
            return element;
        }

        // Element has item DOM reference in it's data storage
        if ( TI_Util.data(element).has('item') ) {
            return TI_Util.data(element).get('item');
        }

        // Item is parent of element
        if ( (item = element.closest('.menu-item')) ) {
            return item;
        }

        // Element's parent has item DOM reference in it's data storage
        if ( (sub = element.closest('.menu-sub')) ) {
            if ( TI_Util.data(sub).has('item') === true ) {
                return TI_Util.data(sub).get('item')
            }
        }
    }

    // Get item parent element
    var _getItemParentElement = function(item) {
        var sub = item.closest('.menu-sub');
        var parentItem;

        if ( sub && TI_Util.data(sub).has('item') ) {
            return TI_Util.data(sub).get('item');
        }

        if ( sub && (parentItem = sub.closest('.menu-item[data-ti-menu-trigger]')) ) {
            return parentItem;
        }

        return null;
    }

    // Get item parent elements
    var _getItemParentElements = function(item) {
        var parents = [];
        var parent;
        var i = 0;

        do {
            parent = _getItemParentElement(item);

            if ( parent ) {
                parents.push(parent);
                item = parent;
            }

            i++;
        } while (parent !== null && i < 20);

        if ( the.triggerElement ) {
            parents.unshift(the.triggerElement);
        }

        return parents;
    }

    // Get item child element
    var _getItemChildElement = function(item) {
        var selector = item;
        var element;

        if ( TI_Util.data(item).get('sub') ) {
            selector = TI_Util.data(item).get('sub');
        }

        if ( selector !== null ) {
            //element = selector.querySelector('.show.menu-item[data-ti-menu-trigger]');
            element = selector.querySelector('.menu-item[data-ti-menu-trigger]');

            if ( element ) {
                return element;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    // Get item child elements
    var _getItemChildElements = function(item) {
        var children = [];
        var child;
        var i = 0;

        do {
            child = _getItemChildElement(item);

            if ( child ) {
                children.push(child);
                item = child;
            }

            i++;
        } while (child !== null && i < 20);

        return children;
    }

    // Show item dropdown
    var _showDropdown = function(item) {
        // Handle dropdown show event
        if ( TI_EventHandler.trigger(the.element, 'ti.menu.dropdown.show', item) === false )  {
            return;
        }

        // Hide all currently shown dropdowns except current one
        TI_Menu.hideDropdowns(item);

        var toggle = _isTriggerElement(item) ? item : _getItemLinkElement(item);
        var sub = _getItemSubElement(item);

        var width = _getOptionFromElementAttribute(item, 'width');
        var height = _getOptionFromElementAttribute(item, 'height');

        var zindex = the.options.dropdown.zindex; // update
        var parentZindex = TI_Util.getHighestZindex(item); // update

        // Apply a new z-index if dropdown's toggle element or it's parent has greater z-index // update
        if ( parentZindex !== null && parentZindex >= zindex ) {
            zindex = parentZindex + 1;
        }

        if ( zindex > 0 ) {
            TI_Util.css(sub, 'z-index', zindex);
        }

        if ( width !== null ) {
            TI_Util.css(sub, 'width', width);
        }

        if ( height !== null ) {
            TI_Util.css(sub, 'height', height);
        }

        TI_Util.css(sub, 'display', '');
        TI_Util.css(sub, 'overflow', '');

        // Init popper(new)
        _initDropdownPopper(item, sub);

        TI_Util.addClass(item, 'show');
        TI_Util.addClass(item, 'menu-dropdown');
        TI_Util.addClass(sub, 'show');

        // Append the sub the the root of the menu
        if ( _getOptionFromElementAttribute(item, 'overflow') === true ) {
            document.body.appendChild(sub);
            TI_Util.data(item).set('sub', sub);
            TI_Util.data(sub).set('item', item);
            TI_Util.data(sub).set('menu', the);
        } else {
            TI_Util.data(sub).set('item', item);
        }

        // Handle dropdown shown event
        TI_EventHandler.trigger(the.element, 'ti.menu.dropdown.shown', item);
    }

    // Hide item dropdown
    var _hideDropdown = function(item) {
        // Handle dropdown hide event
        if ( TI_EventHandler.trigger(the.element, 'ti.menu.dropdown.hide', item) === false )  {
            return;
        }

        var sub = _getItemSubElement(item);

        TI_Util.css(sub, 'z-index', '');
        TI_Util.css(sub, 'width', '');
        TI_Util.css(sub, 'height', '');

        TI_Util.removeClass(item, 'show');
        TI_Util.removeClass(item, 'menu-dropdown');
        TI_Util.removeClass(sub, 'show');

        // Append the sub back to it's parent
        if ( _getOptionFromElementAttribute(item, 'overflow') === true ) {
            if (item.classList.contains('menu-item')) {
                item.appendChild(sub);
            } else {
                TI_Util.insertAfter(the.element, item);
            }

            TI_Util.data(item).remove('sub');
            TI_Util.data(sub).remove('item');
            TI_Util.data(sub).remove('menu');
        }

        // Destroy popper(new)
        _destroyDropdownPopper(item);

        // Handle dropdown hidden event
        TI_EventHandler.trigger(the.element, 'ti.menu.dropdown.hidden', item);
    }

    // Init dropdown popper(new)
    var _initDropdownPopper = function(item, sub) {
        // Setup popper instance
        var reference;
        var attach = _getOptionFromElementAttribute(item, 'attach');

        if ( attach ) {
            if ( attach === 'parent') {
                reference = item.parentNode;
            } else {
                reference = document.querySelector(attach);
            }
        } else {
            reference = item;
        }

        var popper = Popper.createPopper(reference, sub, _getDropdownPopperConfig(item));
        TI_Util.data(item).set('popper', popper);
    }

    // Destroy dropdown popper(new)
    var _destroyDropdownPopper = function(item) {
        if ( TI_Util.data(item).has('popper') === true ) {
            TI_Util.data(item).get('popper').destroy();
            TI_Util.data(item).remove('popper');
        }
    }

    // Prepare popper config for dropdown(see: https://popper.js.org/docs/v2/)
    var _getDropdownPopperConfig = function(item) {
        // Placement
        var placement = _getOptionFromElementAttribute(item, 'placement');
        if (!placement) {
            placement = 'right';
        }

        // Offset
        var offsetValue = _getOptionFromElementAttribute(item, 'offset');
        var offset = offsetValue ? offsetValue.split(",") : [];

        if (offset.length === 2) {
            offset[0] = parseInt(offset[0]);
            offset[1] = parseInt(offset[1]);
        }

        // Strategy
        var strategy = _getOptionFromElementAttribute(item, 'overflow') === true ? 'absolute' : 'fixed';

        var altAxis = _getOptionFromElementAttribute(item, 'flip') !== false ? true : false;

        var popperConfig = {
            placement: placement,
            strategy: strategy,
            modifiers: [{
                name: 'offset',
                options: {
                    offset: offset
                }
            }, {
                name: 'preventOverflow',
                options: {
                    altAxis: altAxis
                }
            }, {
                name: 'flip',
                options: {
                    flipVariations: false
                }
            }]
        };

        return popperConfig;
    }

    // Show item accordion
    var _showAccordion = function(item) {
        if ( TI_EventHandler.trigger(the.element, 'ti.menu.accordion.show', item) === false )  {
            return;
        }

        var sub = _getItemSubElement(item);
        var expand = the.options.accordion.expand;

        if (_getOptionFromElementAttribute(item, 'expand') === true) {
            expand = true;
        } else if (_getOptionFromElementAttribute(item, 'expand') === false) {
            expand = false;
        } else if (_getOptionFromElementAttribute(the.element, 'expand') === true) {
            expand = true;
        }

        if ( expand === false ) {
            _hideAccordions(item);
        }

        if ( TI_Util.data(item).has('popper') === true ) {
            _hideDropdown(item);
        }

        TI_Util.addClass(item, 'hover');

        TI_Util.addClass(item, 'showing');

        TI_Util.slideDown(sub, the.options.accordion.slideSpeed, function() {
            TI_Util.removeClass(item, 'showing');
            TI_Util.addClass(item, 'show');
            TI_Util.addClass(sub, 'show');

            TI_EventHandler.trigger(the.element, 'ti.menu.accordion.shown', item);
        });
    }

    // Hide item accordion
    var _hideAccordion = function(item) {
        if ( TI_EventHandler.trigger(the.element, 'ti.menu.accordion.hide', item) === false )  {
            return;
        }

        var sub = _getItemSubElement(item);

        TI_Util.addClass(item, 'hiding');

        TI_Util.slideUp(sub, the.options.accordion.slideSpeed, function() {
            TI_Util.removeClass(item, 'hiding');
            TI_Util.removeClass(item, 'show');
            TI_Util.removeClass(sub, 'show');

            TI_Util.removeClass(item, 'hover'); // update

            TI_EventHandler.trigger(the.element, 'ti.menu.accordion.hidden', item);
        });
    }

    var _setActiveLink = function(link) {
        var item = _getItemElement(link);

        if (!item) {
            return;
        }

        var parentItems = _getItemParentElements(item);
        var parentTabPane = link.closest('.tab-pane');

        var activeLinks = [].slice.call(the.element.querySelectorAll('.menu-link.active'));
        var activeParentItems = [].slice.call(the.element.querySelectorAll('.menu-item.here, .menu-item.show'));

        if (_getItemSubType(item) === "accordion") {
            _showAccordion(item);
        } else {
            item.classList.add("here");
        }

        if ( parentItems && parentItems.length > 0 ) {
            for (var i = 0, len = parentItems.length; i < len; i++) {
                var parentItem = parentItems[i];

                if (_getItemSubType(parentItem) === "accordion") {
                    _showAccordion(parentItem);
                } else {
                    parentItem.classList.add("here");
                }
            }
        }

        activeLinks.map(function (activeLink) {
            activeLink.classList.remove("active");
        });

        activeParentItems.map(function (activeParentItem) {
            if (activeParentItem.contains(item) === false) {
                activeParentItem.classList.remove("here");
                activeParentItem.classList.remove("show");
            }
        });

        // Handle tab
        if (parentTabPane && bootstrap.Tab) {
            var tabEl = the.element.querySelector('[data-bs-target="#' + parentTabPane.getAttribute("id") + '"]');
            var tab = new bootstrap.Tab(tabEl);

            if (tab) {
                tab.show();
            }
        }

        link.classList.add("active");
    }

    var _getLinkByAttribute = function(value, name = "href") {
        var link = the.element.querySelector('.menu-link[' + name + '="' + value + '"]');

        if (link) {
            return link;
        } else {
            null;
        }
    }

    // Hide all shown accordions of item
    var _hideAccordions = function(item) {
        var itemsToHide = TI_Util.findAll(the.element, '.show[data-ti-menu-trigger]');
        var itemToHide;

        if (itemsToHide && itemsToHide.length > 0) {
            for (var i = 0, len = itemsToHide.length; i < len; i++) {
                itemToHide = itemsToHide[i];

                if ( _getItemSubType(itemToHide) === 'accordion' && itemToHide !== item && item.contains(itemToHide) === false && itemToHide.contains(item) === false ) {
                    _hideAccordion(itemToHide);
                }
            }
        }
    }

    // Get item option(through html attributes)
    var _getOptionFromElementAttribute = function(item, name) {
        var attr;
        var value = null;

        if ( item && item.hasAttribute('data-ti-menu-' + name) ) {
            attr = item.getAttribute('data-ti-menu-' + name);
            value = TI_Util.getResponsiveValue(attr);

            if ( value !== null && String(value) === 'true' ) {
                value = true;
            } else if ( value !== null && String(value) === 'false' ) {
                value = false;
            }
        }

        return value;
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('menu');
    }

    // Construct Class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Event Handlers
    the.click = function(element, e) {
        return _click(element, e);
    }

    the.link = function(element, e) {
        return _link(element, e);
    }

    the.dismiss = function(element, e) {
        return _dismiss(element, e);
    }

    the.mouseover = function(element, e) {
        return _mouseover(element, e);
    }

    the.mouseout = function(element, e) {
        return _mouseout(element, e);
    }

    // General Methods
    the.getItemTriggerType = function(item) {
        return _getOptionFromElementAttribute(item, 'trigger');
    }

    the.getItemSubType = function(element) {
       return _getItemSubType(element);
    }

    the.show = function(item) {
        return _show(item);
    }

    the.hide = function(item) {
        return _hide(item);
    }

    the.toggle = function(item) {
        return _toggle(item);
    }

    the.reset = function(item) {
        return _reset(item);
    }

    the.update = function() {
        return _update();
    }

    the.getElement = function() {
        return the.element;
    }

    the.setActiveLink = function(link) {
        return _setActiveLink(link);
    }

    the.getLinkByAttribute = function(value, name = "href") {
        return _getLinkByAttribute(value, name);
    }

    the.getItemLinkElement = function(item) {
        return _getItemLinkElement(item);
    }

    the.getItemToggleElement = function(item) {
        return _getItemToggleElement(item);
    }

    the.getItemSubElement = function(item) {
        return _getItemSubElement(item);
    }

    the.getItemParentElements = function(item) {
        return _getItemParentElements(item);
    }

    the.isItemSubShown = function(item) {
        return _isItemSubShown(item);
    }

    the.isItemParentShown = function(item) {
        return _isItemParentShown(item);
    }

    the.getTriggerElement = function() {
        return the.triggerElement;
    }

    the.isItemDropdownPermanent = function(item) {
        return _isItemDropdownPermanent(item);
    }

    the.destroy = function() {
        return _destroy();
    }

    the.disable = function() {
        the.disabled = true;
    }

    the.enable = function() {
        the.disabled = false;
    }

    // Accordion Mode Methods
    the.hideAccordions = function(item) {
        return _hideAccordions(item);
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }
};

// Get TI_Menu instance by element
TI_Menu.getInstance = function(element) {
    var menu;
    var item;

    if (!element) {
        return null;
    }

    // Element has menu DOM reference in it's DATA storage
    if ( TI_Util.data(element).has('menu') ) {
        return TI_Util.data(element).get('menu');
    }

    // Element has .menu parent
    if ( menu = element.closest('.menu') ) {
        if ( TI_Util.data(menu).has('menu') ) {
            return TI_Util.data(menu).get('menu');
        }
    }

    // Element has a parent with DOM reference to .menu in it's DATA storage
    if ( TI_Util.hasClass(element, 'menu-link') ) {
        var sub = element.closest('.menu-sub');

        if ( TI_Util.data(sub).has('menu') ) {
            return TI_Util.data(sub).get('menu');
        }
    }

    return null;
}

// Hide all dropdowns and skip one if provided
TI_Menu.hideDropdowns = function(skip) {
    var items = document.querySelectorAll('.show.menu-dropdown[data-ti-menu-trigger]');

    if (items && items.length > 0) {
        for (var i = 0, len = items.length; i < len; i++) {
            var item = items[i];
            var menu = TI_Menu.getInstance(item);

            if ( menu && menu.getItemSubType(item) === 'dropdown' ) {
                if ( skip ) {
                    if ( menu.getItemSubElement(item).contains(skip) === false && item.contains(skip) === false &&  item !== skip ) {
                        menu.hide(item);
                    }
                } else {
                    menu.hide(item);
                }
            }
        }
    }
}

// Update all dropdowns popover instances
TI_Menu.updateDropdowns = function() {
    var items = document.querySelectorAll('.show.menu-dropdown[data-ti-menu-trigger]');

    if (items && items.length > 0) {
        for (var i = 0, len = items.length; i < len; i++) {
            var item = items[i];

            if ( TI_Util.data(item).has('popper') ) {
                TI_Util.data(item).get('popper').forceUpdate();
            }
        }
    }
}

// Global handlers
TI_Menu.initHandlers = function() {
    // Dropdown handler
    document.addEventListener("click", function(e) {
        var items = document.querySelectorAll('.show.menu-dropdown[data-ti-menu-trigger]:not([data-ti-menu-static="true"])');
        var menu;
        var item;
        var sub;
        var menuObj;

        if ( items && items.length > 0 ) {
            for ( var i = 0, len = items.length; i < len; i++ ) {
                item = items[i];
                menuObj = TI_Menu.getInstance(item);

                if (menuObj && menuObj.getItemSubType(item) === 'dropdown') {
                    menu = menuObj.getElement();
                    sub = menuObj.getItemSubElement(item);

                    if ( item === e.target || item.contains(e.target) ) {
                        continue;
                    }

                    if ( sub === e.target || sub.contains(e.target) ) {
                        continue;
                    }

                    menuObj.hide(item);
                }
            }
        }
    });

    // Sub toggle handler(updated)
    TI_Util.on(document.body,  '.menu-item[data-ti-menu-trigger] > .menu-link, [data-ti-menu-trigger]:not(.menu-item):not([data-ti-menu-trigger="auto"])', 'click', function(e) {
        var menu = TI_Menu.getInstance(this);

        if ( menu !== null ) {
            return menu.click(this, e);
        }
    });

    // Link handler
    TI_Util.on(document.body,  '.menu-item:not([data-ti-menu-trigger]) > .menu-link', 'click', function(e) {
        var menu = TI_Menu.getInstance(this);

        if ( menu !== null ) {
            return menu.link(this, e);
        }
    });

    // Dismiss handler
    TI_Util.on(document.body,  '[data-ti-menu-dismiss="true"]', 'click', function(e) {
        var menu = TI_Menu.getInstance(this);

        if ( menu !== null ) {
            return menu.dismiss(this, e);
        }
    });

    // Mouseover handler
    TI_Util.on(document.body,  '[data-ti-menu-trigger], .menu-sub', 'mouseover', function(e) {
        var menu = TI_Menu.getInstance(this);

        if ( menu !== null && menu.getItemSubType(this) === 'dropdown' ) {
            return menu.mouseover(this, e);
        }
    });

    // Mouseout handler
    TI_Util.on(document.body,  '[data-ti-menu-trigger], .menu-sub', 'mouseout', function(e) {
        var menu = TI_Menu.getInstance(this);

        if ( menu !== null && menu.getItemSubType(this) === 'dropdown' ) {
            return menu.mouseout(this, e);
        }
    });

    // Resize handler
    window.addEventListener('resize', function() {
        var menu;
        var timer;

        TI_Util.throttle(timer, function() {
            // Locate and update Offcanvas instances on window resize
            var elements = document.querySelectorAll('[data-ti-menu="true"]');

            if ( elements && elements.length > 0 ) {
                for (var i = 0, len = elements.length; i < len; i++) {
                    menu = TI_Menu.getInstance(elements[i]);
                    if (menu) {
                        menu.update();
                    }
                }
            }
        }, 200);
    });
}

// Render menus by url
TI_Menu.updateByLinkAttribute = function(value, name = "href") {
    // Set menu link active state by attribute value
    var elements = document.querySelectorAll('[data-ti-menu="true"]');

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            var menu = TI_Menu.getInstance(elements[i]);

            if (menu) {
                var link = menu.getLinkByAttribute(value, name);
                if (link) {
                    menu.setActiveLink(link);
                }
            }
        }
    }
}

// Global instances
TI_Menu.createInstances = function(selector = '[data-ti-menu="true"]') {
    // Initialize menus
    var elements = document.querySelectorAll(selector);
    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            new TI_Menu(elements[i]);
        }
    }
}

// Global initialization
TI_Menu.init = function() {
    TI_Menu.createInstances();

    if (TI_MenuHandlersInitialized === false) {
        TI_Menu.initHandlers();

        TI_MenuHandlersInitialized = true;
    }
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Menu;
}

"use strict";

// Class definition
var TI_PasswordMeter = function(element, options) {
    ////////////////////////////
    // ** Private variables  ** //
    ////////////////////////////
    var the = this;

    if (!element) {
        return;
    }

    // Default Options
    var defaultOptions = {
        minLength: 8,
        checkUppercase: true,
        checkLowercase: true,
        checkDigit: true,
        checkChar: true,
        scoreHighlightClass: 'active'
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    // Constructor
    var _construct = function() {
        if ( TI_Util.data(element).has('password-meter') === true ) {
            the = TI_Util.data(element).get('password-meter');
        } else {
            _init();
        }
    }

    // Initialize
    var _init = function() {
        // Variables
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.score = 0;
        the.checkSteps = 5;

        // Elements
        the.element = element;
        the.inputElement = the.element.querySelector('input[type]');
        the.visibilityElement = the.element.querySelector('[data-ti-password-meter-control="visibility"]');
        the.highlightElement = the.element.querySelector('[data-ti-password-meter-control="highlight"]');

        // Set initialized
        the.element.setAttribute('data-ti-password-meter', 'true');

        // Event Handlers
        _handlers();

        // Bind Instance
        TI_Util.data(the.element).set('password-meter', the);
    }

    // Handlers
    var _handlers = function() {
        if (the.highlightElement) {
            the.inputElement.addEventListener('input', function() {
                _check();
            });
        }

        if (the.visibilityElement) {
            the.visibilityElement.addEventListener('click', function() {
                _visibility();
            });
        }
    }

    // Event handlers
    var _check = function() {
        var score = 0;
        var checkScore = _getCheckScore();

        if (_checkLength() === true) {
            score = score + checkScore;
        }

        if (the.options.checkUppercase === true && _checkLowercase() === true) {
            score = score + checkScore;
        }

        if (the.options.checkLowercase === true && _checkUppercase() === true ) {
            score = score + checkScore;
        }

        if (the.options.checkDigit === true && _checkDigit() === true ) {
            score = score + checkScore;
        }

        if (the.options.checkChar === true && _checkChar() === true ) {
            score = score + checkScore;
        }

        the.score = score;

        _highlight();
    }

    var _checkLength = function() {
        return the.inputElement.value.length >= the.options.minLength;  // 20 score
    }

    var _checkLowercase = function() {
        return /[a-z]/.test(the.inputElement.value);  // 20 score
    }

    var _checkUppercase = function() {
        return /[A-Z]/.test(the.inputElement.value);  // 20 score
    }

    var _checkDigit = function() {
        return /[0-9]/.test(the.inputElement.value);  // 20 score
    }

    var _checkChar = function() {
        return /[~`!#@$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(the.inputElement.value);  // 20 score
    }

    var _getCheckScore = function() {
        var count = 1;

        if (the.options.checkUppercase === true) {
            count++;
        }

        if (the.options.checkLowercase === true) {
            count++;
        }

        if (the.options.checkDigit === true) {
            count++;
        }

        if (the.options.checkChar === true) {
            count++;
        }

        the.checkSteps = count;

        return 100 / the.checkSteps;
    }

    var _highlight = function() {
        var items = [].slice.call(the.highlightElement.querySelectorAll('div'));
        var total = items.length;
        var index = 0;
        var checkScore = _getCheckScore();
        var score = _getScore();

        items.map(function (item) {
            index++;

            if ( (checkScore * index * (the.checkSteps / total)) <= score ) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    var _visibility = function() {
        var visibleIcon = the.visibilityElement.querySelector(':scope > i:not(.d-none)');
        var hiddenIcon = the.visibilityElement.querySelector(':scope > i.d-none');

        if (the.inputElement.getAttribute('type').toLowerCase() === 'password' ) {
            the.inputElement.setAttribute('type', 'text');
        }  else {
            the.inputElement.setAttribute('type', 'password');
        }

        visibleIcon.classList.add('d-none');
        hiddenIcon.classList.remove('d-none');

        the.inputElement.focus();
    }

    var _reset = function() {
        the.score = 0;

        _highlight();
    }

    // Gets current password score
    var _getScore = function() {
       return the.score;
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('password-meter');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.check = function() {
        return _check();
    }

    the.getScore = function() {
        return _getScore();
    }

    the.reset = function() {
        return _reset();
    }

    the.destroy = function() {
        return _destroy();
    }
};

// Static methods
TI_PasswordMeter.getInstance = function(element) {
    if ( element !== null && TI_Util.data(element).has('password-meter') ) {
        return TI_Util.data(element).get('password-meter');
    } else {
        return null;
    }
}

// Create instances
TI_PasswordMeter.createInstances = function(selector = '[data-ti-password-meter]') {
    // Get instances
    var elements = document.body.querySelectorAll(selector);

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            // Initialize instances
            new TI_PasswordMeter(elements[i]);
        }
    }
}

// Global initialization
TI_PasswordMeter.init = function() {
    TI_PasswordMeter.createInstances();
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_PasswordMeter;
}
"use strict";

var TI_ScrollHandlersInitialized = false;

// Class definition
var TI_Scroll = function(element, options) {
    ////////////////////////////
    // ** Private Variables  ** //
    ////////////////////////////
    var the = this;

    if (!element) {
        return;
    }

    // Default options
    var defaultOptions = {
        saveState: true
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var _construct = function() {
        if ( TI_Util.data(element).has('scroll') ) {
            the = TI_Util.data(element).get('scroll');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = TI_Util.deepExtend({}, defaultOptions, options);

        // Elements
        the.element = element;
        the.id = the.element.getAttribute('id');

        // Set initialized
        the.element.setAttribute('data-ti-scroll', 'true');

        // Update
        _update();

        // Bind Instance
        TI_Util.data(the.element).set('scroll', the);
    }

    var _setupHeight = function() {
        var heightType = _getHeightType();
        var height = _getHeight();

        // Set height
        if ( height !== null && height.length > 0 ) {
            TI_Util.css(the.element, heightType, height);
        } else {
            TI_Util.css(the.element, heightType, '');
        }
    }

    var _setupState = function () {
        var namespace = _getStorageNamespace();

        if ( _getOption('save-state') === true && the.id ) {
            if ( localStorage.getItem(namespace + the.id + 'st') ) {
                var pos = parseInt(localStorage.getItem(namespace + the.id + 'st'));

                if ( pos > 0 ) {
                    the.element.scroll({
                        top: pos,
                        behavior: 'instant'
                    });
                }
            }
        }
    }

    var _getStorageNamespace = function(postfix) {
        return document.body.hasAttribute("data-ti-name") ? document.body.getAttribute("data-ti-name") + "_" : "";
    }

    var _setupScrollHandler = function() {
        if ( _getOption('save-state') === true && the.id ) {
            the.element.addEventListener('scroll', _scrollHandler);
        } else {
            the.element.removeEventListener('scroll', _scrollHandler);
        }
    }

    var _destroyScrollHandler = function() {
        the.element.removeEventListener('scroll', _scrollHandler);
    }

    var _resetHeight = function() {
        TI_Util.css(the.element, _getHeightType(), '');
    }

    var _scrollHandler = function () {
        var namespace = _getStorageNamespace();
        localStorage.setItem(namespace + the.id + 'st', the.element.scrollTop);
    }

    var _update = function() {
        // Activate/deactivate
        if ( _getOption('activate') === true || the.element.hasAttribute('data-ti-scroll-activate') === false ) {
            _setupHeight();
            _setupStretchHeight();
            _setupScrollHandler();
            _setupState();
        } else {
            _resetHeight()
            _destroyScrollHandler();
        }
    }

    var _setupStretchHeight = function() {
        var stretch = _getOption('stretch');

        // Stretch
        if ( stretch !== null ) {
            var elements = document.querySelectorAll(stretch);

            if ( elements && elements.length == 2 ) {
                var element1 = elements[0];
                var element2 = elements[1];
                var diff = _getElementHeight(element2) - _getElementHeight(element1);

                if (diff > 0) {
                    var height = parseInt(TI_Util.css(the.element, _getHeightType())) + diff;

                    TI_Util.css(the.element, _getHeightType(), String(height) + 'px');
                }
            }
        }
    }

    var _getHeight = function() {
        var height = _getOption(_getHeightType());

        if ( height instanceof Function ) {
            return height.call();
        } else if ( height !== null && typeof height === 'string' && height.toLowerCase() === 'auto' ) {
            return _getAutoHeight();
        } else {
            return height;
        }
    }

    var _getAutoHeight = function() {
        var height = TI_Util.getViewPort().height;
        var dependencies = _getOption('dependencies');
        var wrappers = _getOption('wrappers');
        var offset = _getOption('offset');

        // Spacings
        height = height - _getElementSpacing(the.element);

        // Height dependencies
        //console.log('Q:' + JSON.stringify(dependencies));

        if ( dependencies !== null ) {
            var elements = document.querySelectorAll(dependencies);

            if ( elements && elements.length > 0 ) {
                for ( var i = 0, len = elements.length; i < len; i++ ) {
                    if ( TI_Util.visible(elements[i]) === false ) {
                        continue;
                    }

                    height = height - _getElementHeight(elements[i]);
                }
            }
        }

        // Wrappers
        if ( wrappers !== null ) {
            var elements = document.querySelectorAll(wrappers);
            if ( elements && elements.length > 0 ) {
                for ( var i = 0, len = elements.length; i < len; i++ ) {
                    if ( TI_Util.visible(elements[i]) === false ) {
                        continue;
                    }

                    height = height - _getElementSpacing(elements[i]);
                }
            }
        }

        // Custom offset
        if ( offset !== null && typeof offset !== 'object') {
            height = height - parseInt(offset);
        }

        return String(height) + 'px';
    }

    var _getElementHeight = function(element) {
        var height = 0;

        if (element !== null) {
            height = height + parseInt(TI_Util.css(element, 'height'));
            height = height + parseInt(TI_Util.css(element, 'margin-top'));
            height = height + parseInt(TI_Util.css(element, 'margin-bottom'));

            if (TI_Util.css(element, 'border-top')) {
                height = height + parseInt(TI_Util.css(element, 'border-top'));
            }

            if (TI_Util.css(element, 'border-bottom')) {
                height = height + parseInt(TI_Util.css(element, 'border-bottom'));
            }
        }

        return height;
    }

    var _getElementSpacing = function(element) {
        var spacing = 0;

        if (element !== null) {
            spacing = spacing + parseInt(TI_Util.css(element, 'margin-top'));
            spacing = spacing + parseInt(TI_Util.css(element, 'margin-bottom'));
            spacing = spacing + parseInt(TI_Util.css(element, 'padding-top'));
            spacing = spacing + parseInt(TI_Util.css(element, 'padding-bottom'));

            if (TI_Util.css(element, 'border-top')) {
                spacing = spacing + parseInt(TI_Util.css(element, 'border-top'));
            }

            if (TI_Util.css(element, 'border-bottom')) {
                spacing = spacing + parseInt(TI_Util.css(element, 'border-bottom'));
            }
        }

        return spacing;
    }

    var _getOption = function(name) {
        if ( the.element.hasAttribute('data-ti-scroll-' + name) === true ) {
            var attr = the.element.getAttribute('data-ti-scroll-' + name);

            var value = TI_Util.getResponsiveValue(attr);

            if ( value !== null && String(value) === 'true' ) {
                value = true;
            } else if ( value !== null && String(value) === 'false' ) {
                value = false;
            }

            return value;
        } else {
            var optionName = TI_Util.snakeToCamel(name);

            if ( the.options[optionName] ) {
                return TI_Util.getResponsiveValue(the.options[optionName]);
            } else {
                return null;
            }
        }
    }

    var _getHeightType = function() {
        if (_getOption('height')) {
            return 'height';
        } if (_getOption('min-height')) {
            return 'min-height';
        } if (_getOption('max-height')) {
            return 'max-height';
        }
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('scroll');
    }

    // Construct Class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    the.update = function() {
        return _update();
    }

    the.getHeight = function() {
        return _getHeight();
    }

    the.getElement = function() {
        return the.element;
    }

    the.destroy = function() {
        return _destroy();
    }
};

// Static methods
TI_Scroll.getInstance = function(element) {
    if ( element !== null && TI_Util.data(element).has('scroll') ) {
        return TI_Util.data(element).get('scroll');
    } else {
        return null;
    }
}

// Create instances
TI_Scroll.createInstances = function(selector = '[data-ti-scroll="true"]') {
    // Initialize Menus
    var elements = document.body.querySelectorAll(selector);

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            new TI_Scroll(elements[i]);
        }
    }
}

// Window resize handling
TI_Scroll.handleResize = function() {
    window.addEventListener('resize', function() {
        var timer;

        TI_Util.throttle(timer, function() {
            // Locate and update Offcanvas instances on window resize
            var elements = document.body.querySelectorAll('[data-ti-scroll="true"]');

            if ( elements && elements.length > 0 ) {
                for (var i = 0, len = elements.length; i < len; i++) {
                    var scroll = TI_Scroll.getInstance(elements[i]);
                    if (scroll) {
                        scroll.update();
                    }
                }
            }
        }, 200);
    });
}

// Global initialization
TI_Scroll.init = function() {
    TI_Scroll.createInstances();

    if (TI_ScrollHandlersInitialized === false) {
        TI_Scroll.handleResize();

        TI_ScrollHandlersInitialized = true;
    }
};

// Webpack Support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Scroll;
}

"use strict";

// Class definition
var TI_Scrolltop = function(element, options) {
    ////////////////////////////
    // ** Private variables  ** //
    ////////////////////////////
    var the = this;

    if ( typeof element === "undefined" || element === null ) {
        return;
    }

    // Default options
    var defaultOptions = {
        offset: 300,
        speed: 600
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        if (TI_Util.data(element).has('scrolltop')) {
            the = TI_Util.data(element).get('scrolltop');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.uid = TI_Util.getUniqueId('scrolltop');
        the.element = element;

        // Set initialized
        the.element.setAttribute('data-ti-scrolltop', 'true');

        // Event Handlers
        _handlers();

        // Bind Instance
        TI_Util.data(the.element).set('scrolltop', the);
    }

    var _handlers = function() {
        var timer;

        window.addEventListener('scroll', function() {
            TI_Util.throttle(timer, function() {
                _scroll();
            }, 200);
        });

        TI_Util.addEvent(the.element, 'click', function(e) {
            e.preventDefault();

            _go();
        });
    }

    var _scroll = function() {
        var offset = parseInt(_getOption('offset'));

        var pos = TI_Util.getScrollTop(); // current vertical position

        if ( pos > offset ) {
            if ( document.body.hasAttribute('data-ti-scrolltop') === false ) {
                document.body.setAttribute('data-ti-scrolltop', 'on');
            }
        } else {
            if ( document.body.hasAttribute('data-ti-scrolltop') === true ) {
                document.body.removeAttribute('data-ti-scrolltop');
            }
        }
    }

    var _go = function() {
        var speed = parseInt(_getOption('speed'));

        window.scrollTo({top: 0, behavior: 'smooth'});
        //TI_Util.scrollTop(0, speed);
    }

    var _getOption = function(name) {
        if ( the.element.hasAttribute('data-ti-scrolltop-' + name) === true ) {
            var attr = the.element.getAttribute('data-ti-scrolltop-' + name);
            var value = TI_Util.getResponsiveValue(attr);

            if ( value !== null && String(value) === 'true' ) {
                value = true;
            } else if ( value !== null && String(value) === 'false' ) {
                value = false;
            }

            return value;
        } else {
            var optionName = TI_Util.snakeToCamel(name);

            if ( the.options[optionName] ) {
                return TI_Util.getResponsiveValue(the.options[optionName]);
            } else {
                return null;
            }
        }
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('scrolltop');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.go = function() {
        return _go();
    }

    the.getElement = function() {
        return the.element;
    }

    the.destroy = function() {
        return _destroy();
    }
};

// Static methods
TI_Scrolltop.getInstance = function(element) {
    if (element && TI_Util.data(element).has('scrolltop')) {
        return TI_Util.data(element).get('scrolltop');
    } else {
        return null;
    }
}

// Create instances
TI_Scrolltop.createInstances = function(selector = '[data-ti-scrolltop="true"]') {
    // Initialize Menus
    var elements = document.body.querySelectorAll(selector);

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            new TI_Scrolltop(elements[i]);
        }
    }
}

// Global initialization
TI_Scrolltop.init = function() {
    TI_Scrolltop.createInstances();
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Scrolltop;
}

// "use strict";
//
// // Class definition
// var TI_Search = function(element, options) {
//     ////////////////////////////
//     // ** Private variables  ** //
//     ////////////////////////////
//     var the = this;
//
//     if (!element) {
//         return;
//     }
//
//     // Default Options
//     var defaultOptions = {
//         minLength: 2,  // Miniam text lenght to query search
//         keypress: true,  // Enable search on keypress
//         enter: true,  // Enable search on enter key press
//         layout: 'menu',  // Use 'menu' or 'inline' layout options to display search results
//         responsive: null, // Pass integer value or bootstrap compatible breakpoint key(sm,md,lg,xl,xxl) to enable reponsive form mode for device width below the breakpoint value
//         showOnFocus: true // Always show menu on input focus
//     };
//
//     ////////////////////////////
//     // ** Private methods  ** //
//     ////////////////////////////
//
//     // Construct
//     var _construct = function() {
//         if ( TI_Util.data(element).has('search') === true ) {
//             the = TI_Util.data(element).get('search');
//         } else {
//             _init();
//         }
//     }
//
//     // Init
//     var _init = function() {
//         // Variables
//         the.options = TI_Util.deepExtend({}, defaultOptions, options);
//         the.processing = false;
//
//         // Elements
//         the.element = element;
//         the.contentElement = _getElement('content');
//         the.formElement = _getElement('form');
//         the.inputElement = _getElement('input');
//         the.spinnerElement = _getElement('spinner');
//         the.clearElement = _getElement('clear');
//         the.toggleElement = _getElement('toggle');
//         the.submitElement = _getElement('submit');
//         the.toolbarElement = _getElement('toolbar');
//
//         the.resultsElement = _getElement('results');
//         the.suggestionElement = _getElement('suggestion');
//         the.emptyElement = _getElement('empty');
//
//         // Set initialized
//         the.element.setAttribute('data-ti-search', 'true');
//
//         // Layout
//         the.layout = _getOption('layout');
//
//         // Menu
//         if ( the.layout === 'menu' ) {
//             the.menuObject = new TI_Menu(the.contentElement);
//         } else {
//             the.menuObject = null;
//         }
//
//         // Update
//         _update();
//
//         // Event Handlers
//         _handlers();
//
//         // Bind Instance
//         TI_Util.data(the.element).set('search', the);
//     }
//
//     // Handlera
//     var _handlers = function() {
//         // Focus
//         the.inputElement.addEventListener('focus', _focus);
//
//         // Blur
//         the.inputElement.addEventListener('blur', _blur);
//
//         // Keypress
//         if ( _getOption('keypress') === true ) {
//             the.inputElement.addEventListener('input', _input);
//         }
//
//         // Submit
//         if ( the.submitElement ) {
//             the.submitElement.addEventListener('click', _search);
//         }
//
//         // Enter
//         if ( _getOption('enter') === true ) {
//             the.inputElement.addEventListener('keypress', _enter);
//         }
//
//         // Clear
//         if ( the.clearElement ) {
//             the.clearElement.addEventListener('click', _clear);
//         }
//
//         // Menu
//         if ( the.menuObject ) {
//             // Toggle menu
//             if ( the.toggleElement ) {
//                 the.toggleElement.addEventListener('click', _show);
//
//                 the.menuObject.on('ti.menu.dropdown.show', function(item) {
//                     if (TI_Util.visible(the.toggleElement)) {
//                         the.toggleElement.classList.add('active');
//                         the.toggleElement.classList.add('show');
//                     }
//                 });
//
//                 the.menuObject.on('ti.menu.dropdown.hide', function(item) {
//                     if (TI_Util.visible(the.toggleElement)) {
//                         the.toggleElement.classList.remove('active');
//                         the.toggleElement.classList.remove('show');
//                     }
//                 });
//             }
//
//             the.menuObject.on('ti.menu.dropdown.shown', function() {
//                 the.inputElement.focus();
//             });
//         }
//
//         // Window resize handling
//         window.addEventListener('resize', function() {
//             var timer;
//
//             TI_Util.throttle(timer, function() {
//                 _update();
//             }, 200);
//         });
//     }
//
//     // Focus
//     var _focus = function() {
//         the.element.classList.add('focus');
//
//         if ( _getOption('show-on-focus') === true || the.inputElement.value.length >= minLength ) {
//             _show();
//         }
//     }
//
//     // Blur
//     var _blur = function() {
//         the.element.classList.remove('focus');
//     }
//
//     // Enter
//     var _enter = function(e) {
//         var key = e.charCode || e.keyCode || 0;
//
//         if (key == 13) {
//             e.preventDefault();
//
//             _search();
//         }
//     }
//
//     // Input
//     var _input = function() {
//         if ( _getOption('min-length') )  {
//             var minLength = parseInt(_getOption('min-length'));
//
//             if ( the.inputElement.value.length >= minLength ) {
//                 _search();
//             } else if ( the.inputElement.value.length === 0 ) {
//                 _clear();
//             }
//         }
//     }
//
//     // Search
//     var _search = function() {
//         if (the.processing === false) {
//             // Show search spinner
//             if (the.spinnerElement) {
//                 the.spinnerElement.classList.remove("d-none");
//             }
//
//             // Hide search clear button
//             if (the.clearElement) {
//                 the.clearElement.classList.add("d-none");
//             }
//
//             // Hide search toolbar
//             if (the.toolbarElement && the.formElement.contains(the.toolbarElement)) {
//                 the.toolbarElement.classList.add("d-none");
//             }
//
//             // Focus input
//             the.inputElement.focus();
//
//             the.processing = true;
//             TI_EventHandler.trigger(the.element, 'ti.search.process', the);
//         }
//     }
//
//     // Complete
//     var _complete = function() {
//         if (the.spinnerElement) {
//             the.spinnerElement.classList.add("d-none");
//         }
//
//         // Show search toolbar
//         if (the.clearElement) {
//             the.clearElement.classList.remove("d-none");
//         }
//
//         if ( the.inputElement.value.length === 0 ) {
//             _clear();
//         }
//
//         // Focus input
//         the.inputElement.focus();
//
//         _show();
//
//         the.processing = false;
//     }
//
//     // Clear
//     var _clear = function() {
//         if ( TI_EventHandler.trigger(the.element, 'ti.search.clear', the) === false )  {
//             return;
//         }
//
//         // Clear and focus input
//         the.inputElement.value = "";
//         the.inputElement.focus();
//
//         // Hide clear icon
//         if (the.clearElement) {
//             the.clearElement.classList.add("d-none");
//         }
//
//         // Show search toolbar
//         if (the.toolbarElement && the.formElement.contains(the.toolbarElement)) {
//             the.toolbarElement.classList.remove("d-none");
//         }
//
//         // Hide menu
//         if ( _getOption('show-on-focus') === false ) {
//             _hide();
//         }
//
//         TI_EventHandler.trigger(the.element, 'ti.search.cleared', the);
//     }
//
//     // Update
//     var _update = function() {
//         // Handle responsive form
//         if (the.layout === 'menu') {
//             var responsiveFormMode = _getResponsiveFormMode();
//
//             if ( responsiveFormMode === 'on' && the.contentElement.contains(the.formElement) === false ) {
//                 the.contentElement.prepend(the.formElement);
//                 the.formElement.classList.remove('d-none');
//             } else if ( responsiveFormMode === 'off' && the.contentElement.contains(the.formElement) === true ) {
//                 the.element.prepend(the.formElement);
//                 the.formElement.classList.add('d-none');
//             }
//         }
//     }
//
//     // Show menu
//     var _show = function() {
//         if ( the.menuObject ) {
//             _update();
//
//             the.menuObject.show(the.element);
//         }
//     }
//
//     // Hide menu
//     var _hide = function() {
//         if ( the.menuObject ) {
//             _update();
//
//             the.menuObject.hide(the.element);
//         }
//     }
//
//     // Get option
//     var _getOption = function(name) {
//         if ( the.element.hasAttribute('data-ti-search-' + name) === true ) {
//             var attr = the.element.getAttribute('data-ti-search-' + name);
//             var value = TI_Util.getResponsiveValue(attr);
//
//             if ( value !== null && String(value) === 'true' ) {
//                 value = true;
//             } else if ( value !== null && String(value) === 'false' ) {
//                 value = false;
//             }
//
//             return value;
//         } else {
//             var optionName = TI_Util.snakeToCamel(name);
//
//             if ( the.options[optionName] ) {
//                 return TI_Util.getResponsiveValue(the.options[optionName]);
//             } else {
//                 return null;
//             }
//         }
//     }
//
//     // Get element
//     var _getElement = function(name) {
//         return the.element.querySelector('[data-ti-search-element="' + name + '"]');
//     }
//
//     // Check if responsive form mode is enabled
//     var _getResponsiveFormMode = function() {
//         var responsive = _getOption('responsive');
//         var width = TI_Util.getViewPort().width;
//
//         if (!responsive) {
//             return null;
//         }
//
//         var breakpoint = TI_Util.getBreakpoint(responsive);
//
//         if (!breakpoint ) {
//             breakpoint = parseInt(responsive);
//         }
//
//         if (width < breakpoint) {
//             return "on";
//         } else {
//             return "off";
//         }
//     }
//
//     var _destroy = function() {
//         TI_Util.data(the.element).remove('search');
//     }
//
//     // Construct class
//     _construct();
//
//     ///////////////////////
//     // ** Public API  ** //
//     ///////////////////////
//
//     // Plugin API
//     the.show = function() {
//         return _show();
//     }
//
//     the.hide = function() {
//         return _hide();
//     }
//
//     the.update = function() {
//         return _update();
//     }
//
//     the.search = function() {
//         return _search();
//     }
//
//     the.complete = function() {
//         return _complete();
//     }
//
//     the.clear = function() {
//         return _clear();
//     }
//
//     the.isProcessing = function() {
//         return the.processing;
//     }
//
//     the.getQuery = function() {
//         return the.inputElement.value;
//     }
//
//     the.getMenu = function() {
//         return the.menuObject;
//     }
//
//     the.getFormElement = function() {
//         return the.formElement;
//     }
//
//     the.getInputElement = function() {
//         return the.inputElement;
//     }
//
//     the.getContentElement = function() {
//         return the.contentElement;
//     }
//
//     the.getElement = function() {
//         return the.element;
//     }
//
//     the.destroy = function() {
//         return _destroy();
//     }
//
//     // Event API
//     the.on = function(name, handler) {
//         return TI_EventHandler.on(the.element, name, handler);
//     }
//
//     the.one = function(name, handler) {
//         return TI_EventHandler.one(the.element, name, handler);
//     }
//
//     the.off = function(name, handlerId) {
//         return TI_EventHandler.off(the.element, name, handlerId);
//     }
// };
//
// // Static methods
// TI_Search.getInstance = function(element) {
//     if ( element !== null && TI_Util.data(element).has('search') ) {
//         return TI_Util.data(element).get('search');
//     } else {
//         return null;
//     }
// }
//
// // Webpack support
// if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
//     module.exports = TI_Search;
// }

"use strict";

// Class definition
var TI_Stepper = function(element, options) {
    //////////////////////////////
    // ** Private variables  ** //
    //////////////////////////////
    var the = this;

    if ( typeof element === "undefined" || element === null ) {
        return;
    }

    // Default Options
    var defaultOptions = {
        startIndex: 1,
        animation: false,
        animationSpeed: '0.3s',
        animationNextClass: 'animate__animated animate__slideInRight animate__fast',
        animationPreviousClass: 'animate__animated animate__slideInLeft animate__fast'
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        if ( TI_Util.data(element).has('stepper') === true ) {
            the = TI_Util.data(element).get('stepper');
        } else {
            _init();
        }
    }

    var _init = function() {
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.uid = TI_Util.getUniqueId('stepper');

        the.element = element;

        // Set initialized
        the.element.setAttribute('data-ti-stepper', 'true');

        // Elements
        the.steps = TI_Util.findAll(the.element, '[data-ti-stepper-element="nav"]');
        the.btnNext = TI_Util.find(the.element, '[data-ti-stepper-action="next"]');
        the.btnPrevious = TI_Util.find(the.element, '[data-ti-stepper-action="previous"]');
        the.btnSubmit = TI_Util.find(the.element, '[data-ti-stepper-action="submit"]');

        // Variables
        the.totalStepsNumber = the.steps.length;
        the.passedStepIndex = 0;
        the.currentStepIndex = 1;
        the.clickedStepIndex = 0;

        // Set Current Step
        if ( the.options.startIndex > 1 ) {
            _goTo(the.options.startIndex);
        }

        // Event listeners
        the.nextListener = function(e) {
            e.preventDefault();

            TI_EventHandler.trigger(the.element, 'ti.stepper.next', the);
        };

        the.previousListener = function(e) {
            e.preventDefault();

            TI_EventHandler.trigger(the.element, 'ti.stepper.previous', the);
        };

        the.stepListener = function(e) {
            e.preventDefault();

            if ( the.steps && the.steps.length > 0 ) {
                for (var i = 0, len = the.steps.length; i < len; i++) {
                    if ( the.steps[i] === this ) {
                        the.clickedStepIndex = i + 1;

                        TI_EventHandler.trigger(the.element, 'ti.stepper.click', the);

                        return;
                    }
                }
            }
        };

        // Event Handlers
        TI_Util.addEvent(the.btnNext, 'click', the.nextListener);

        TI_Util.addEvent(the.btnPrevious, 'click', the.previousListener);

        the.stepListenerId = TI_Util.on(the.element, '[data-ti-stepper-action="step"]', 'click', the.stepListener);

        // Bind Instance
        TI_Util.data(the.element).set('stepper', the);
    }

    var _goTo = function(index) {
        // Trigger "change" event
        TI_EventHandler.trigger(the.element, 'ti.stepper.change', the);

        // Skip if this step is already shown
        if ( index === the.currentStepIndex || index > the.totalStepsNumber || index < 0 ) {
            return;
        }

        // Validate step number
        index = parseInt(index);

        // Set current step
        the.passedStepIndex = the.currentStepIndex;
        the.currentStepIndex = index;

        // Refresh elements
        _refreshUI();

        // Trigger "changed" event
        TI_EventHandler.trigger(the.element, 'ti.stepper.changed', the);

        return the;
    }

    var _goNext = function() {
        return _goTo( _getNextStepIndex() );
    }

    var _goPrevious = function() {
        return _goTo( _getPreviousStepIndex() );
    }

    var _goLast = function() {
        return _goTo( _getLastStepIndex() );
    }

    var _goFirst = function() {
        return _goTo( _getFirstStepIndex() );
    }

    var _refreshUI = function() {
        var state = '';

        if ( _isLastStep() ) {
            state = 'last';
        } else if ( _isFirstStep() ) {
            state = 'first';
        } else {
            state = 'between';
        }

        // Set state class
        TI_Util.removeClass(the.element, 'last');
        TI_Util.removeClass(the.element, 'first');
        TI_Util.removeClass(the.element, 'between');

        TI_Util.addClass(the.element, state);

        // Step Items
        var elements = TI_Util.findAll(the.element, '[data-ti-stepper-element="nav"], [data-ti-stepper-element="content"], [data-ti-stepper-element="info"]');

        if ( elements && elements.length > 0 ) {
            for (var i = 0, len = elements.length; i < len; i++) {
                var element = elements[i];
                var index = TI_Util.index(element) + 1;

                TI_Util.removeClass(element, 'current');
                TI_Util.removeClass(element, 'completed');
                TI_Util.removeClass(element, 'pending');

                if ( index == the.currentStepIndex ) {
                    TI_Util.addClass(element, 'current');

                    if ( the.options.animation !== false && element.getAttribute('data-ti-stepper-element') == 'content' ) {
                        TI_Util.css(element, 'animationDuration', the.options.animationSpeed);

                        var animation = _getStepDirection(the.passedStepIndex) === 'previous' ?  the.options.animationPreviousClass : the.options.animationNextClass;
                        TI_Util.animateClass(element, animation);
                    }
                } else {
                    if ( index < the.currentStepIndex ) {
                        TI_Util.addClass(element, 'completed');
                    } else {
                        TI_Util.addClass(element, 'pending');
                    }
                }
            }
        }
    }

    var _isLastStep = function() {
        return the.currentStepIndex === the.totalStepsNumber;
    }

    var _isFirstStep = function() {
        return the.currentStepIndex === 1;
    }

    var _isBetweenStep = function() {
        return _isLastStep() === false && _isFirstStep() === false;
    }

    var _getNextStepIndex = function() {
        if ( the.totalStepsNumber >= ( the.currentStepIndex + 1 ) ) {
            return the.currentStepIndex + 1;
        } else {
            return the.totalStepsNumber;
        }
    }

    var _getPreviousStepIndex = function() {
        if ( ( the.currentStepIndex - 1 ) > 1 ) {
            return the.currentStepIndex - 1;
        } else {
            return 1;
        }
    }

    var _getFirstStepIndex = function(){
        return 1;
    }

    var _getLastStepIndex = function() {
        return the.totalStepsNumber;
    }

    var _getTotalStepsNumber = function() {
        return the.totalStepsNumber;
    }

    var _getStepDirection = function(index) {
        if ( index > the.currentStepIndex ) {
            return 'next';
        } else {
            return 'previous';
        }
    }

    var _getStepContent = function(index) {
        var content = TI_Util.findAll(the.element, '[data-ti-stepper-element="content"]');

        if ( content[index-1] ) {
            return content[index-1];
        } else {
            return false;
        }
    }

    var _destroy = function() {
        // Event Handlers
        TI_Util.removeEvent(the.btnNext, 'click', the.nextListener);

        TI_Util.removeEvent(the.btnPrevious, 'click', the.previousListener);

        TI_Util.off(the.element, 'click', the.stepListenerId);

        TI_Util.data(the.element).remove('stepper');
    }

    // Construct Class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.getElement = function(index) {
        return the.element;
    }

    the.goTo = function(index) {
        return _goTo(index);
    }

    the.goPrevious = function() {
        return _goPrevious();
    }

    the.goNext = function() {
        return _goNext();
    }

    the.goFirst = function() {
        return _goFirst();
    }

    the.goLast = function() {
        return _goLast();
    }

    the.getCurrentStepIndex = function() {
        return the.currentStepIndex;
    }

    the.getNextStepIndex = function() {
        return _getNextStepIndex();
    }

    the.getPassedStepIndex = function() {
        return the.passedStepIndex;
    }

    the.getClickedStepIndex = function() {
        return the.clickedStepIndex;
    }

    the.getPreviousStepIndex = function() {
        return _getPreviousStepIndex();
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return TI_EventHandler.trigger(the.element, name, event, the, event);
    }
};

// Static methods
TI_Stepper.getInstance = function(element) {
    if ( element !== null && TI_Util.data(element).has('stepper') ) {
        return TI_Util.data(element).get('stepper');
    } else {
        return null;
    }
}

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Stepper;
}

"use strict";

var TI_StickyHandlersInitialized = false;

// Class definition
var TI_Sticky = function(element, options) {
    ////////////////////////////
    // ** Private Variables  ** //
    ////////////////////////////
    var the = this;

    if ( typeof element === "undefined" || element === null ) {
        return;
    }

    // Default Options
    var defaultOptions = {
        offset: 200,
        reverse: false,
        release: null,
        animation: true,
        animationSpeed: '0.3s',
        animationClass: 'animation-slide-in-down'
    };
    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var _construct = function() {
        if ( TI_Util.data(element).has('sticky') === true ) {
            the = TI_Util.data(element).get('sticky');
        } else {
            _init();
        }
    }

    var _init = function() {
        the.element = element;
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.uid = TI_Util.getUniqueId('sticky');
        the.name = the.element.getAttribute('data-ti-sticky-name');
        the.attributeName = 'data-ti-sticky-' + the.name;
        the.attributeName2 = 'data-ti-' + the.name;
        the.eventTriggerState = true;
        the.lastScrollTop = 0;
        the.scrollHandler;

        // Set initialized
        the.element.setAttribute('data-ti-sticky', 'true');

        // Event Handlers
        window.addEventListener('scroll', _scroll);

        // Initial Launch
        _scroll();

        // Bind Instance
        TI_Util.data(the.element).set('sticky', the);
    }

    var _scroll = function(e) {
        var offset = _getOption('offset');
        var release = _getOption('release');
        var reverse = _getOption('reverse');
        var st;
        var attrName;
        var diff;

        // Exit if false
        if ( offset === false ) {
            _disable();
            return;
        }

        offset = parseInt(offset);
        release = release ? document.querySelector(release) : null;

        st = TI_Util.getScrollTop();
        diff = document.documentElement.scrollHeight - window.innerHeight - TI_Util.getScrollTop();

        var proceed = (!release || (release.offsetTop - release.clientHeight) > st);

        if ( reverse === true ) {  // Release on reverse scroll mode
            if ( st > offset && proceed ) {
                if ( document.body.hasAttribute(the.attributeName) === false) {

                    if (_enable() === false) {
                        return;
                    }

                    document.body.setAttribute(the.attributeName, 'on');
                    document.body.setAttribute(the.attributeName2, 'on');
                    the.element.setAttribute("data-ti-sticky-enabled", "true");
                }

                if ( the.eventTriggerState === true ) {
                    TI_EventHandler.trigger(the.element, 'ti.sticky.on', the);
                    TI_EventHandler.trigger(the.element, 'ti.sticky.change', the);

                    the.eventTriggerState = false;
                }
            } else { // Back scroll mode
                if ( document.body.hasAttribute(the.attributeName) === true) {
                    _disable();
                    document.body.removeAttribute(the.attributeName);
                    document.body.removeAttribute(the.attributeName2);
                    the.element.removeAttribute("data-ti-sticky-enabled");
                }

                if ( the.eventTriggerState === false ) {
                    TI_EventHandler.trigger(the.element, 'ti.sticky.off', the);
                    TI_EventHandler.trigger(the.element, 'ti.sticky.change', the);
                    the.eventTriggerState = true;
                }
            }

            the.lastScrollTop = st;
        } else { // Classic scroll mode
            if ( st > offset && proceed ) {
                if ( document.body.hasAttribute(the.attributeName) === false) {

                    if (_enable() === false) {
                        return;
                    }

                    document.body.setAttribute(the.attributeName, 'on');
                    document.body.setAttribute(the.attributeName2, 'on');
                    the.element.setAttribute("data-ti-sticky-enabled", "true");
                }

                if ( the.eventTriggerState === true ) {
                    TI_EventHandler.trigger(the.element, 'ti.sticky.on', the);
                    TI_EventHandler.trigger(the.element, 'ti.sticky.change', the);
                    the.eventTriggerState = false;
                }
            } else { // back scroll mode
                if ( document.body.hasAttribute(the.attributeName) === true ) {
                    _disable();
                    document.body.removeAttribute(the.attributeName);
                    document.body.removeAttribute(the.attributeName2);
                    the.element.removeAttribute("data-ti-sticky-enabled");
                }

                if ( the.eventTriggerState === false ) {
                    TI_EventHandler.trigger(the.element, 'ti.sticky.off', the);
                    TI_EventHandler.trigger(the.element, 'ti.sticky.change', the);
                    the.eventTriggerState = true;
                }
            }
        }

        if (release) {
            if ( release.offsetTop - release.clientHeight > st ) {
                the.element.setAttribute('data-ti-sticky-released', 'true');
            } else {
                the.element.removeAttribute('data-ti-sticky-released');
            }
        }
    }

    var _enable = function(update) {
        var top = _getOption('top');
        top = top ? parseInt(top) : 0;

        var left = _getOption('left');
        var right = _getOption('right');
        var width = _getOption('width');
        var zindex = _getOption('zindex');
        var dependencies = _getOption('dependencies');
        var classes = _getOption('class');

        var height = _calculateHeight();
        var heightOffset = _getOption('height-offset');
        heightOffset = heightOffset ? parseInt(heightOffset) : 0;

        if (height + heightOffset + top > TI_Util.getViewPort().height) {
            return false;
        }

        if ( update !== true && _getOption('animation') === true ) {
            TI_Util.css(the.element, 'animationDuration', _getOption('animationSpeed'));
            TI_Util.animateClass(the.element, 'animation ' + _getOption('animationClass'));
        }

        if ( classes !== null ) {
            TI_Util.addClass(the.element, classes);
        }

        if ( zindex !== null ) {
            TI_Util.css(the.element, 'z-index', zindex);
            TI_Util.css(the.element, 'position', 'fixed');
        }

        if ( top >= 0 ) {
            TI_Util.css(the.element, 'top', String(top) + 'px');
        }

        if ( width !== null ) {
            if (width['target']) {
                var targetElement = document.querySelector(width['target']);
                if (targetElement) {
                    width = TI_Util.css(targetElement, 'width');
                }
            }

            TI_Util.css(the.element, 'width', width);
        }

        if ( left !== null ) {
            if ( String(left).toLowerCase() === 'auto' ) {
                var offsetLeft = TI_Util.offset(the.element).left;

                if ( offsetLeft >= 0 ) {
                    TI_Util.css(the.element, 'left', String(offsetLeft) + 'px');
                }
            } else {
                TI_Util.css(the.element, 'left', left);
            }
        }

        if ( right !== null ) {
            TI_Util.css(the.element, 'right', right);
        }

        // Height dependencies
        if ( dependencies !== null ) {
            var dependencyElements = document.querySelectorAll(dependencies);

            if ( dependencyElements && dependencyElements.length > 0 ) {
                for ( var i = 0, len = dependencyElements.length; i < len; i++ ) {
                    TI_Util.css(dependencyElements[i], 'padding-top', String(height) + 'px');
                }
            }
        }
    }

    var _disable = function() {
        TI_Util.css(the.element, 'top', '');
        TI_Util.css(the.element, 'width', '');
        TI_Util.css(the.element, 'left', '');
        TI_Util.css(the.element, 'right', '');
        TI_Util.css(the.element, 'z-index', '');
        TI_Util.css(the.element, 'position', '');

        var dependencies = _getOption('dependencies');
        var classes = _getOption('class');

        if ( classes !== null ) {
            TI_Util.removeClass(the.element, classes);
        }

        // Height dependencies
        if ( dependencies !== null ) {
            var dependencyElements = document.querySelectorAll(dependencies);

            if ( dependencyElements && dependencyElements.length > 0 ) {
                for ( var i = 0, len = dependencyElements.length; i < len; i++ ) {
                    TI_Util.css(dependencyElements[i], 'padding-top', '');
                }
            }
        }
    }

    var _check = function() {

    }

    var _calculateHeight = function() {
        var height = parseFloat(TI_Util.css(the.element, 'height'));

        height = height + parseFloat(TI_Util.css(the.element, 'margin-top'));
        height = height + parseFloat(TI_Util.css(the.element, 'margin-bottom'));

        if (TI_Util.css(element, 'border-top')) {
            height = height + parseFloat(TI_Util.css(the.element, 'border-top'));
        }

        if (TI_Util.css(element, 'border-bottom')) {
            height = height + parseFloat(TI_Util.css(the.element, 'border-bottom'));
        }

        return height;
    }

    var _getOption = function(name) {
        if ( the.element.hasAttribute('data-ti-sticky-' + name) === true ) {
            var attr = the.element.getAttribute('data-ti-sticky-' + name);
            var value = TI_Util.getResponsiveValue(attr);

            if ( value !== null && String(value) === 'true' ) {
                value = true;
            } else if ( value !== null && String(value) === 'false' ) {
                value = false;
            }

            return value;
        } else {
            var optionName = TI_Util.snakeToCamel(name);

            if ( the.options[optionName] ) {
                return TI_Util.getResponsiveValue(the.options[optionName]);
            } else {
                return null;
            }
        }
    }

    var _destroy = function() {
        window.removeEventListener('scroll', _scroll);
        TI_Util.data(the.element).remove('sticky');
    }

    // Construct Class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Methods
    the.update = function() {
        if ( document.body.hasAttribute(the.attributeName) === true ) {
            _disable();
            document.body.removeAttribute(the.attributeName);
            document.body.removeAttribute(the.attributeName2);
            _enable(true);
            document.body.setAttribute(the.attributeName, 'on');
            document.body.setAttribute(the.attributeName2, 'on');
        }
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return TI_EventHandler.trigger(the.element, name, event, the, event);
    }
};

// Static methods
TI_Sticky.getInstance = function(element) {
    if ( element !== null && TI_Util.data(element).has('sticky') ) {
        return TI_Util.data(element).get('sticky');
    } else {
        return null;
    }
}

// Create instances
TI_Sticky.createInstances = function(selector = '[data-ti-sticky="true"]') {
    // Initialize Menus
    var elements = document.body.querySelectorAll(selector);
    var sticky;

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            sticky = new TI_Sticky(elements[i]);
        }
    }
}

// Window resize handler
TI_Sticky.handleResize = function() {
    window.addEventListener('resize', function() {
        var timer;

        TI_Util.throttle(timer, function() {
            // Locate and update Offcanvas instances on window resize
            var elements = document.body.querySelectorAll('[data-ti-sticky="true"]');

            if ( elements && elements.length > 0 ) {
                for (var i = 0, len = elements.length; i < len; i++) {
                    var sticky = TI_Sticky.getInstance(elements[i]);
                    if (sticky) {
                        sticky.update();
                    }
                }
            }
        }, 200);
    });
}

// Global initialization
TI_Sticky.init = function() {
    TI_Sticky.createInstances();

    if (TI_StickyHandlersInitialized === false) {
        TI_Sticky.handleResize();
        TI_StickyHandlersInitialized = true;
    }
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Sticky;
}

"use strict";

var TI_SwapperHandlersInitialized = false;

// Class definition
var TI_Swapper = function(element, options) {
    ////////////////////////////
    // ** Private Variables  ** //
    ////////////////////////////
    var the = this;

    if ( typeof element === "undefined" || element === null ) {
        return;
    }

    // Default Options
    var defaultOptions = {
        mode: 'append'
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var _construct = function() {
        if ( TI_Util.data(element).has('swapper') === true ) {
            the = TI_Util.data(element).get('swapper');
        } else {
            _init();
        }
    }

    var _init = function() {
        the.element = element;
        the.options = TI_Util.deepExtend({}, defaultOptions, options);

        // Set initialized
        the.element.setAttribute('data-ti-swapper', 'true');

        // Initial update
        _update();

        // Bind Instance
        TI_Util.data(the.element).set('swapper', the);
    }

    var _update = function(e) {
        var parentSelector = _getOption('parent');

        var mode = _getOption('mode');
        var parentElement = parentSelector ? document.querySelector(parentSelector) : null;


        if (parentElement && element.parentNode !== parentElement) {
            if (mode === 'prepend') {
                parentElement.prepend(element);
            } else if (mode === 'append') {
                parentElement.append(element);
            }
        }
    }

    var _getOption = function(name) {
        if ( the.element.hasAttribute('data-ti-swapper-' + name) === true ) {
            var attr = the.element.getAttribute('data-ti-swapper-' + name);
            var value = TI_Util.getResponsiveValue(attr);

            if ( value !== null && String(value) === 'true' ) {
                value = true;
            } else if ( value !== null && String(value) === 'false' ) {
                value = false;
            }

            return value;
        } else {
            var optionName = TI_Util.snakeToCamel(name);

            if ( the.options[optionName] ) {
                return TI_Util.getResponsiveValue(the.options[optionName]);
            } else {
                return null;
            }
        }
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('swapper');
    }

    // Construct Class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Methods
    the.update = function() {
        _update();
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return TI_EventHandler.trigger(the.element, name, event, the, event);
    }
};

// Static methods
TI_Swapper.getInstance = function(element) {
    if ( element !== null && TI_Util.data(element).has('swapper') ) {
        return TI_Util.data(element).get('swapper');
    } else {
        return null;
    }
}

// Create instances
TI_Swapper.createInstances = function(selector = '[data-ti-swapper="true"]') {
    // Initialize Menus
    var elements = document.querySelectorAll(selector);
    var swapper;

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            swapper = new TI_Swapper(elements[i]);
        }
    }
}

// Window resize handler
TI_Swapper.handleResize = function() {
    window.addEventListener('resize', function() {
        var timer;

        TI_Util.throttle(timer, function() {
            // Locate and update Offcanvas instances on window resize
            var elements = document.querySelectorAll('[data-ti-swapper="true"]');

            if ( elements && elements.length > 0 ) {
                for (var i = 0, len = elements.length; i < len; i++) {
                    var swapper = TI_Swapper.getInstance(elements[i]);
                    if (swapper) {
                        swapper.update();
                    }
                }
            }
        }, 200);
    });
};

// Global initialization
TI_Swapper.init = function() {
    TI_Swapper.createInstances();

    if (TI_SwapperHandlersInitialized === false) {
        TI_Swapper.handleResize();
        TI_SwapperHandlersInitialized = true;
    }
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Swapper;
}

"use strict";

// Class definition
var TI_Toggle = function(element, options) {
    ////////////////////////////
    // ** Private variables  ** //
    ////////////////////////////
    var the = this;

    if (!element) {
        return;
    }

    // Default Options
    var defaultOptions = {
        saveState: true
    };

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    var _construct = function() {
        if ( TI_Util.data(element).has('toggle') === true ) {
            the = TI_Util.data(element).get('toggle');
        } else {
            _init();
        }
    }

    var _init = function() {
        // Variables
        the.options = TI_Util.deepExtend({}, defaultOptions, options);
        the.uid = TI_Util.getUniqueId('toggle');

        // Elements
        the.element = element;

        the.target = document.querySelector(the.element.getAttribute('data-ti-toggle-target')) ? document.querySelector(the.element.getAttribute('data-ti-toggle-target')) : the.element;
        the.state = the.element.hasAttribute('data-ti-toggle-state') ? the.element.getAttribute('data-ti-toggle-state') : '';
        the.mode = the.element.hasAttribute('data-ti-toggle-mode') ? the.element.getAttribute('data-ti-toggle-mode') : '';
        the.attribute = 'data-ti-' + the.element.getAttribute('data-ti-toggle-name');

        // Event Handlers
        _handlers();

        // Bind Instance
        TI_Util.data(the.element).set('toggle', the);
    }

    var _handlers = function() {
        TI_Util.addEvent(the.element, 'click', function(e) {
            e.preventDefault();

            if ( the.mode !== '' ) {
                if ( the.mode === 'off' && _isEnabled() === false ) {
                    _toggle();
                } else if ( the.mode === 'on' && _isEnabled() === true ) {
                    _toggle();
                }
            } else {
                _toggle();
            }
        });
    }

    // Event handlers
    var _toggle = function() {
        // Trigger "after.toggle" event
        TI_EventHandler.trigger(the.element, 'ti.toggle.change', the);

        if ( _isEnabled() ) {
            _disable();
        } else {
            _enable();
        }

        // Trigger "before.toggle" event
        TI_EventHandler.trigger(the.element, 'ti.toggle.changed', the);

        return the;
    }

    var _enable = function() {
        if ( _isEnabled() === true ) {
            return;
        }

        TI_EventHandler.trigger(the.element, 'ti.toggle.enable', the);

        the.target.setAttribute(the.attribute, 'on');

        if (the.state.length > 0) {
            the.element.classList.add(the.state);
        }

        if ( typeof TI_Cookie !== 'undefined' && the.options.saveState === true ) {
            TI_Cookie.set(the.attribute, 'on');
        }

        TI_EventHandler.trigger(the.element, 'ti.toggle.enabled', the);

        return the;
    }

    var _disable = function() {
        if ( _isEnabled() === false ) {
            return;
        }

        TI_EventHandler.trigger(the.element, 'ti.toggle.disable', the);

        the.target.removeAttribute(the.attribute);

        if (the.state.length > 0) {
            the.element.classList.remove(the.state);
        }

        if ( typeof TI_Cookie !== 'undefined' && the.options.saveState === true ) {
            TI_Cookie.remove(the.attribute);
        }

        TI_EventHandler.trigger(the.element, 'ti.toggle.disabled', the);

        return the;
    }

    var _isEnabled = function() {
        return (String(the.target.getAttribute(the.attribute)).toLowerCase() === 'on');
    }

    var _destroy = function() {
        TI_Util.data(the.element).remove('toggle');
    }

    // Construct class
    _construct();

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    // Plugin API
    the.toggle = function() {
        return _toggle();
    }

    the.enable = function() {
        return _enable();
    }

    the.disable = function() {
        return _disable();
    }

    the.isEnabled = function() {
        return _isEnabled();
    }

    the.goElement = function() {
        return the.element;
    }

    the.destroy = function() {
        return _destroy();
    }

    // Event API
    the.on = function(name, handler) {
        return TI_EventHandler.on(the.element, name, handler);
    }

    the.one = function(name, handler) {
        return TI_EventHandler.one(the.element, name, handler);
    }

    the.off = function(name, handlerId) {
        return TI_EventHandler.off(the.element, name, handlerId);
    }

    the.trigger = function(name, event) {
        return TI_EventHandler.trigger(the.element, name, event, the, event);
    }
};

// Static methods
TI_Toggle.getInstance = function(element) {
    if ( element !== null && TI_Util.data(element).has('toggle') ) {
        return TI_Util.data(element).get('toggle');
    } else {
        return null;
    }
}

// Create instances
TI_Toggle.createInstances = function(selector = '[data-ti-toggle]') {
    // Get instances
    var elements = document.body.querySelectorAll(selector);

    if ( elements && elements.length > 0 ) {
        for (var i = 0, len = elements.length; i < len; i++) {
            // Initialize instances
            new TI_Toggle(elements[i]);
        }
    }
}

// Global initialization
TI_Toggle.init = function() {
    TI_Toggle.createInstances();
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Toggle;
}
"use strict";

/**
 * @class TI_Util  base utilize class that privides helper functions
 */

// Polyfills

// Element.matches() polyfill
if (!Element.prototype.matches) {
    Element.prototype.matches = function(s) {
        var matches = (this.document || this.ownerDocument).querySelectorAll(s),
            i = matches.length;
        while (--i >= 0 && matches.item(i) !== this) {}
        return i > -1;
    };
}

/**
 * Element.closest() polyfill
 * https://developer.mozilla.org/en-US/docs/Web/API/Element/closest#Polyfill
 */
if (!Element.prototype.closest) {
	Element.prototype.closest = function (s) {
		var el = this;
		var ancestor = this;
		if (!document.documentElement.contains(el)) return null;
		do {
			if (ancestor.matches(s)) return ancestor;
			ancestor = ancestor.parentElement;
		} while (ancestor !== null);
		return null;
	};
}

/**
 * ChildNode.remove() polyfill
 * https://gomakethings.com/removing-an-element-from-the-dom-the-es6-way/
 * @author Chris Ferdinandi
 * @license MIT
 */
(function (elem) {
	for (var i = 0; i < elem.length; i++) {
		if (!window[elem[i]] || 'remove' in window[elem[i]].prototype) continue;
		window[elem[i]].prototype.remove = function () {
			this.parentNode.removeChild(this);
		};
	}
})(['Element', 'CharacterData', 'DocumentType']);


//
// requestAnimationFrame polyfill by Erik Möller.
//  With fixes from Paul Irish and Tino Zijdel
//
//  http://paulirish.com/2011/requestanimationframe-for-smart-animating/
//  http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
//
//  MIT license
//
(function() {
    var lastTime = 0;
    var vendors = ['webkit', 'moz'];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
        window.cancelAnimationFrame =
            window[vendors[x] + 'CancelAnimationFrame'] || window[vendors[x] + 'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() {
                callback(currTime + timeToCall);
            }, timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

// Source: https://github.com/jserz/js_piece/blob/master/DOM/ParentNode/prepend()/prepend().md
(function(arr) {
    arr.forEach(function(item) {
        if (item.hasOwnProperty('prepend')) {
            return;
        }
        Object.defineProperty(item, 'prepend', {
            configurable: true,
            enumerable: true,
            writable: true,
            value: function prepend() {
                var argArr = Array.prototype.slice.call(arguments),
                    docFrag = document.createDocumentFragment();

                argArr.forEach(function(argItem) {
                    var isNode = argItem instanceof Node;
                    docFrag.appendChild(isNode ? argItem : document.createTextNode(String(argItem)));
                });

                this.insertBefore(docFrag, this.firstChild);
            }
        });
    });
})([Element.prototype, Document.prototype, DocumentFragment.prototype]);

// getAttributeNames
if (Element.prototype.getAttributeNames == undefined) {
  Element.prototype.getAttributeNames = function () {
    var attributes = this.attributes;
    var length = attributes.length;
    var result = new Array(length);
    for (var i = 0; i < length; i++) {
      result[i] = attributes[i].name;
    }
    return result;
  };
}

// Global variables
window.TI_UtilElementDataStore = {};
window.TI_UtilElementDataStoreID = 0;
window.TI_UtilDelegatedEventHandlers = {};

var TI_Util = function() {
    var resizeHandlers = [];

    /**
     * Handle window resize event with some
     * delay to attach event handlers upon resize complete
     */
    var _windowResizeHandler = function() {
        var _runResizeHandlers = function() {
            // reinitialize other subscribed elements
            for (var i = 0; i < resizeHandlers.length; i++) {
                var each = resizeHandlers[i];
                each.call();
            }
        };

        var timer;

        window.addEventListener('resize', function() {
            TI_Util.throttle(timer, function() {
                _runResizeHandlers();
            }, 200);
        });
    };

    return {
        /**
         * Class main initializer.
         * @param {object} settings.
         * @returns null
         */
        //main function to initiate the theme
        init: function(settings) {
            _windowResizeHandler();
        },

        /**
         * Adds window resize event handler.
         * @param {function} callback function.
         */
        addResizeHandler: function(callback) {
            resizeHandlers.push(callback);
        },

        /**
         * Removes window resize event handler.
         * @param {function} callback function.
         */
        removeResizeHandler: function(callback) {
            for (var i = 0; i < resizeHandlers.length; i++) {
                if (callback === resizeHandlers[i]) {
                    delete resizeHandlers[i];
                }
            }
        },

        /**
         * Trigger window resize handlers.
         */
        runResizeHandlers: function() {
            _runResizeHandlers();
        },

        resize: function() {
            if (typeof(Event) === 'function') {
                // modern browsers
                window.dispatchEvent(new Event('resize'));
            } else {
                // for IE and other old browsers
                // causes deprecation warning on modern browsers
                var evt = window.document.createEvent('UIEvents');
                evt.initUIEvent('resize', true, false, window, 0);
                window.dispatchEvent(evt);
            }
        },

        /**
         * Get GET parameter value from URL.
         * @param {string} paramName Parameter name.
         * @returns {string}
         */
        getURLParam: function(paramName) {
            var searchString = window.location.search.substring(1),
                i, val, params = searchString.split("&");

            for (i = 0; i < params.length; i++) {
                val = params[i].split("=");
                if (val[0] == paramName) {
                    return unescape(val[1]);
                }
            }

            return null;
        },

        /**
         * Checks whether current device is mobile touch.
         * @returns {boolean}
         */
        isMobileDevice: function() {
            var test = (this.getViewPort().width < this.getBreakpoint('lg') ? true : false);

            if (test === false) {
                // For use within normal web clients
                test = navigator.userAgent.match(/iPad/i) != null;
            }

            return test;
        },

        /**
         * Checks whether current device is desktop.
         * @returns {boolean}
         */
        isDesktopDevice: function() {
            return TI_Util.isMobileDevice() ? false : true;
        },

        /**
         * Gets browser window viewport size. Ref:
         * http://andylangton.co.uk/articles/javascript/get-viewport-size-javascript/
         * @returns {object}
         */
        getViewPort: function() {
            var e = window,
                a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }

            return {
                width: e[a + 'Width'],
                height: e[a + 'Height']
            };
        },

		/**
         * Checks whether given device mode is currently activated.
         * @param {string} mode Responsive mode name(e.g: desktop,
         *     desktop-and-tablet, tablet, tablet-and-mobile, mobile)
         * @returns {boolean}
         */
        isBreakpointUp: function(mode) {
            var width = this.getViewPort().width;
			var breakpoint = this.getBreakpoint(mode);

			return (width >= breakpoint);
        },

		isBreakpointDown: function(mode) {
            var width = this.getViewPort().width;
			var breakpoint = this.getBreakpoint(mode);

			return (width < breakpoint);
        },

        getViewportWidth: function() {
            return this.getViewPort().width;
        },

        /**
         * Generates unique ID for give prefix.
         * @param {string} prefix Prefix for generated ID
         * @returns {boolean}
         */
        getUniqueId: function(prefix) {
            return prefix + Math.floor(Math.random() * (new Date()).getTime());
        },

        /**
         * Gets window width for give breakpoint mode.
         * @param {string} mode Responsive mode name(e.g: xl, lg, md, sm)
         * @returns {number}
         */
        getBreakpoint: function(breakpoint) {
            var value = this.getCssVariableValue('--bs-' + breakpoint);

            if ( value ) {
                value = parseInt(value.trim());
            }

            return value;
        },

        /**
         * Checks whether object has property matchs given key path.
         * @param {object} obj Object contains values paired with given key path
         * @param {string} keys Keys path seperated with dots
         * @returns {object}
         */
        isset: function(obj, keys) {
            var stone;

            keys = keys || '';

            if (keys.indexOf('[') !== -1) {
                throw new Error('Unsupported object path notation.');
            }

            keys = keys.split('.');

            do {
                if (obj === undefined) {
                    return false;
                }

                stone = keys.shift();

                if (!obj.hasOwnProperty(stone)) {
                    return false;
                }

                obj = obj[stone];

            } while (keys.length);

            return true;
        },

        /**
         * Gets highest z-index of the given element parents
         * @param {object} el jQuery element object
         * @returns {number}
         */
        getHighestZindex: function(el) {
            var position, value;

            while (el && el !== document) {
                // Ignore z-index if position is set to a value where z-index is ignored by the browser
                // This makes behavior of this function consistent across browsers
                // WebKit always returns auto if the element is positioned
                position = TI_Util.css(el, 'position');

                if (position === "absolute" || position === "relative" || position === "fixed") {
                    // IE returns 0 when zIndex is not specified
                    // other browsers return a string
                    // we ignore the case of nested elements with an explicit value of 0
                    // <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
                    value = parseInt(TI_Util.css(el, 'z-index'));

                    if (!isNaN(value) && value !== 0) {
                        return value;
                    }
                }

                el = el.parentNode;
            }

            return 1;
        },

        /**
         * Checks whether the element has any parent with fixed positionfreg
         * @param {object} el jQuery element object
         * @returns {boolean}
         */
        hasFixedPositionedParent: function(el) {
            var position;

            while (el && el !== document) {
                position = TI_Util.css(el, 'position');

                if (position === "fixed") {
                    return true;
                }

                el = el.parentNode;
            }

            return false;
        },

        /**
         * Simulates delay
         */
        sleep: function(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds) {
                    break;
                }
            }
        },

        /**
         * Gets randomly generated integer value within given min and max range
         * @param {number} min Range start value
         * @param {number} max Range end value
         * @returns {number}
         */
        getRandomInt: function(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },

        /**
         * Checks whether Angular library is included
         * @returns {boolean}
         */
        isAngularVersion: function() {
            return window.Zone !== undefined ? true : false;
        },

        // Deep extend:  $.extend(true, {}, objA, objB);
        deepExtend: function(out) {
            out = out || {};

            for (var i = 1; i < arguments.length; i++) {
                var obj = arguments[i];
                if (!obj) continue;

                for (var key in obj) {
                    if (!obj.hasOwnProperty(key)) {
                        continue;
                    }

                    // based on https://javascriptweblog.wordpress.com/2011/08/08/fixing-the-javascript-typeof-operator/
                    if ( Object.prototype.toString.call(obj[key]) === '[object Object]' ) {
                        out[key] = TI_Util.deepExtend(out[key], obj[key]);
                        continue;
                    }

                    out[key] = obj[key];
                }
            }

            return out;
        },

        // extend:  $.extend({}, objA, objB);
        extend: function(out) {
            out = out || {};

            for (var i = 1; i < arguments.length; i++) {
                if (!arguments[i])
                    continue;

                for (var key in arguments[i]) {
                    if (arguments[i].hasOwnProperty(key))
                        out[key] = arguments[i][key];
                }
            }

            return out;
        },

        getBody: function() {
            return document.getElementsByTagName('body')[0];
        },

        /**
         * Checks whether the element has given classes
         * @param {object} el jQuery element object
         * @param {string} Classes string
         * @returns {boolean}
         */
        hasClasses: function(el, classes) {
            if (!el) {
                return;
            }

            var classesArr = classes.split(" ");

            for (var i = 0; i < classesArr.length; i++) {
                if (TI_Util.hasClass(el, TI_Util.trim(classesArr[i])) == false) {
                    return false;
                }
            }

            return true;
        },

        hasClass: function(el, className) {
            if (!el) {
                return;
            }

            return el.classList ? el.classList.contains(className) : new RegExp('\\b' + className + '\\b').test(el.className);
        },

        addClass: function(el, className) {
            if (!el || typeof className === 'undefined') {
                return;
            }

            var classNames = className.split(' ');

            if (el.classList) {
                for (var i = 0; i < classNames.length; i++) {
                    if (classNames[i] && classNames[i].length > 0) {
                        el.classList.add(TI_Util.trim(classNames[i]));
                    }
                }
            } else if (!TI_Util.hasClass(el, className)) {
                for (var x = 0; x < classNames.length; x++) {
                    el.className += ' ' + TI_Util.trim(classNames[x]);
                }
            }
        },

        removeClass: function(el, className) {
          if (!el || typeof className === 'undefined') {
                return;
            }

            var classNames = className.split(' ');

            if (el.classList) {
                for (var i = 0; i < classNames.length; i++) {
                    el.classList.remove(TI_Util.trim(classNames[i]));
                }
            } else if (TI_Util.hasClass(el, className)) {
                for (var x = 0; x < classNames.length; x++) {
                    el.className = el.className.replace(new RegExp('\\b' + TI_Util.trim(classNames[x]) + '\\b', 'g'), '');
                }
            }
        },

        triggerCustomEvent: function(el, eventName, data) {
            var event;
            if (window.CustomEvent) {
                event = new CustomEvent(eventName, {
                    detail: data
                });
            } else {
                event = document.createEvent('CustomEvent');
                event.initCustomEvent(eventName, true, true, data);
            }

            el.dispatchEvent(event);
        },

        triggerEvent: function(node, eventName) {
            // Make sure we use the ownerDocument from the provided node to avoid cross-window problems
            var doc;

            if (node.ownerDocument) {
                doc = node.ownerDocument;
            } else if (node.nodeType == 9) {
                // the node may be the document itself, nodeType 9 = DOCUMENT_NODE
                doc = node;
            } else {
                throw new Error("Invalid node passed to fireEvent: " + node.id);
            }

            if (node.dispatchEvent) {
                // Gecko-style approach (now the standard) takes more work
                var eventClass = "";

                // Different events have different event classes.
                // If this switch statement can't map an eventName to an eventClass,
                // the event firing is going to fail.
                switch (eventName) {
                case "click": // Dispatching of 'click' appears to not work correctly in Safari. Use 'mousedown' or 'mouseup' instead.
                case "mouseenter":
                case "mouseleave":
                case "mousedown":
                case "mouseup":
                    eventClass = "MouseEvents";
                    break;

                case "focus":
                case "change":
                case "blur":
                case "select":
                    eventClass = "HTMLEvents";
                    break;

                default:
                    throw "fireEvent: Couldn't find an event class for event '" + eventName + "'.";
                    break;
                }
                var event = doc.createEvent(eventClass);

                var bubbles = eventName == "change" ? false : true;
                event.initEvent(eventName, bubbles, true); // All events created as bubbling and cancelable.

                event.synthetic = true; // allow detection of synthetic events
                // The second parameter says go ahead with the default action
                node.dispatchEvent(event, true);
            } else if (node.fireEvent) {
                // IE-old school style
                var event = doc.createEventObject();
                event.synthetic = true; // allow detection of synthetic events
                node.fireEvent("on" + eventName, event);
            }
        },

        index: function( el ){
            var c = el.parentNode.children, i = 0;
            for(; i < c.length; i++ )
                if( c[i] == el ) return i;
        },

        trim: function(string) {
            return string.trim();
        },

        eventTriggered: function(e) {
            if (e.currentTarget.dataset.triggered) {
                return true;
            } else {
                e.currentTarget.dataset.triggered = true;

                return false;
            }
        },

        remove: function(el) {
            if (el && el.parentNode) {
                el.parentNode.removeChild(el);
            }
        },

        find: function(parent, query) {
            if ( parent !== null) {
                return parent.querySelector(query);
            } else {
                return null;
            }
        },

        findAll: function(parent, query) {
            if ( parent !== null ) {
                return parent.querySelectorAll(query);
            } else {
                return null;
            }
        },

        insertAfter: function(el, referenceNode) {
            return referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
        },

        parents: function(elem, selector) {
            // Set up a parent array
            var parents = [];

            // Push each parent element to the array
            for ( ; elem && elem !== document; elem = elem.parentNode ) {
                if (selector) {
                    if (elem.matches(selector)) {
                        parents.push(elem);
                    }
                    continue;
                }
                parents.push(elem);
            }

            // Return our parent array
            return parents;
        },

        children: function(el, selector, log) {
            if (!el || !el.childNodes) {
                return null;
            }

            var result = [],
                i = 0,
                l = el.childNodes.length;

            for (var i; i < l; ++i) {
                if (el.childNodes[i].nodeType == 1 && TI_Util.matches(el.childNodes[i], selector, log)) {
                    result.push(el.childNodes[i]);
                }
            }

            return result;
        },

        child: function(el, selector, log) {
            var children = TI_Util.children(el, selector, log);

            return children ? children[0] : null;
        },

        matches: function(el, selector, log) {
            var p = Element.prototype;
            var f = p.matches || p.webkitMatchesSelector || p.mozMatchesSelector || p.msMatchesSelector || function(s) {
                return [].indexOf.call(document.querySelectorAll(s), this) !== -1;
            };

            if (el && el.tagName) {
                return f.call(el, selector);
            } else {
                return false;
            }
        },

        data: function(el) {
            return {
                set: function(name, data) {
                    if (!el) {
                        return;
                    }

                    if (el.customDataTag === undefined) {
                        window.TI_UtilElementDataStoreID++;
                        el.customDataTag = window.TI_UtilElementDataStoreID;
                    }

                    if (window.TI_UtilElementDataStore[el.customDataTag] === undefined) {
                        window.TI_UtilElementDataStore[el.customDataTag] = {};
                    }

                    window.TI_UtilElementDataStore[el.customDataTag][name] = data;
                },

                get: function(name) {
                    if (!el) {
                        return;
                    }

                    if (el.customDataTag === undefined) {
                        return null;
                    }

                    return this.has(name) ? window.TI_UtilElementDataStore[el.customDataTag][name] : null;
                },

                has: function(name) {
                    if (!el) {
                        return false;
                    }

                    if (el.customDataTag === undefined) {
                        return false;
                    }

                    return (window.TI_UtilElementDataStore[el.customDataTag] && window.TI_UtilElementDataStore[el.customDataTag][name]) ? true : false;
                },

                remove: function(name) {
                    if (el && this.has(name)) {
                        delete window.TI_UtilElementDataStore[el.customDataTag][name];
                    }
                }
            };
        },

        outerWidth: function(el, margin) {
            var width;

            if (margin === true) {
                width = parseFloat(el.offsetWidth);
                width += parseFloat(TI_Util.css(el, 'margin-left')) + parseFloat(TI_Util.css(el, 'margin-right'));

                return parseFloat(width);
            } else {
                width = parseFloat(el.offsetWidth);

                return width;
            }
        },

        offset: function(el) {
            var rect, win;

            if ( !el ) {
                return;
            }

            // Return zeros for disconnected and hidden (display: none) elements (gh-2310)
            // Support: IE <=11 only
            // Running getBoundingClientRect on a
            // disconnected node in IE throws an error

            if ( !el.getClientRects().length ) {
                return { top: 0, left: 0 };
            }

            // Get document-relative position by adding viewport scroll to viewport-relative gBCR
            rect = el.getBoundingClientRect();
            win = el.ownerDocument.defaultView;

            return {
                top: rect.top + win.pageYOffset,
                left: rect.left + win.pageXOffset,
                right: window.innerWidth - (el.offsetLeft + el.offsetWidth)
            };
        },

        height: function(el) {
            return TI_Util.css(el, 'height');
        },

        outerHeight: function(el, withMargin) {
            var height = el.offsetHeight;
            var style;

            if (typeof withMargin !== 'undefined' && withMargin === true) {
                style = getComputedStyle(el);
                height += parseInt(style.marginTop) + parseInt(style.marginBottom);

                return height;
            } else {
                return height;
            }
        },

        visible: function(el) {
            return !(el.offsetWidth === 0 && el.offsetHeight === 0);
        },

        isVisibleInContainer: function (el, container, offset = 0) {
            const eleTop = el.offsetTop;
            const eleBottom = eleTop + el.clientHeight + offset;
            const containerTop = container.scrollTop;
            const containerBottom = containerTop + container.clientHeight;

            // The element is fully visible in the container
            return (
                (eleTop >= containerTop && eleBottom <= containerBottom)
            );
        },

        getRelativeTopPosition: function (el, container) {
            return el.offsetTop - container.offsetTop;
        },

        attr: function(el, name, value) {
            if (el == undefined) {
                return;
            }

            if (value !== undefined) {
                el.setAttribute(name, value);
            } else {
                return el.getAttribute(name);
            }
        },

        hasAttr: function(el, name) {
            if (el == undefined) {
                return;
            }

            return el.getAttribute(name) ? true : false;
        },

        removeAttr: function(el, name) {
            if (el == undefined) {
                return;
            }

            el.removeAttribute(name);
        },

        animate: function(from, to, duration, update, easing, done) {
            /**
             * TinyAnimate.easings
             *  Adapted from jQuery Easing
             */
            var easings = {};
            var easing;

            easings.linear = function(t, b, c, d) {
                return c * t / d + b;
            };

            easing = easings.linear;

            // Early bail out if called incorrectly
            if (typeof from !== 'number' ||
                typeof to !== 'number' ||
                typeof duration !== 'number' ||
                typeof update !== 'function') {
                return;
            }

            // Create mock done() function if necessary
            if (typeof done !== 'function') {
                done = function() {};
            }

            // Pick implementation (requestAnimationFrame | setTimeout)
            var rAF = window.requestAnimationFrame || function(callback) {
                window.setTimeout(callback, 1000 / 50);
            };

            // Animation loop
            var canceled = false;
            var change = to - from;

            function loop(timestamp) {
                var time = (timestamp || +new Date()) - start;

                if (time >= 0) {
                    update(easing(time, from, change, duration));
                }
                if (time >= 0 && time >= duration) {
                    update(to);
                    done();
                } else {
                    rAF(loop);
                }
            }

            update(from);

            // Start animation loop
            var start = window.performance && window.performance.now ? window.performance.now() : +new Date();

            rAF(loop);
        },

        actualCss: function(el, prop, cache) {
            var css = '';

            if (el instanceof HTMLElement === false) {
                return;
            }

            if (!el.getAttribute('ti-hidden-' + prop) || cache === false) {
                var value;

                // the element is hidden so:
                // making the el block so we can meassure its height but still be hidden
                css = el.style.cssText;
                el.style.cssText = 'position: absolute; visibility: hidden; display: block;';

                if (prop == 'width') {
                    value = el.offsetWidth;
                } else if (prop == 'height') {
                    value = el.offsetHeight;
                }

                el.style.cssText = css;

                // store it in cache
                el.setAttribute('ti-hidden-' + prop, value);

                return parseFloat(value);
            } else {
                // store it in cache
                return parseFloat(el.getAttribute('ti-hidden-' + prop));
            }
        },

        actualHeight: function(el, cache) {
            return TI_Util.actualCss(el, 'height', cache);
        },

        actualWidth: function(el, cache) {
            return TI_Util.actualCss(el, 'width', cache);
        },

        getScroll: function(element, method) {
            // The passed in `method` value should be 'Top' or 'Left'
            method = 'scroll' + method;
            return (element == window || element == document) ? (
                self[(method == 'scrollTop') ? 'pageYOffset' : 'pageXOffset'] ||
                (browserSupportsBoxModel && document.documentElement[method]) ||
                document.body[method]
            ) : element[method];
        },

        css: function(el, styleProp, value, important) {
            if (!el) {
                return;
            }

            if (value !== undefined) {
                if ( important === true ) {
                    el.style.setProperty(styleProp, value, 'important');
                } else {
                    el.style[styleProp] = value;
                }
            } else {
                var defaultView = (el.ownerDocument || document).defaultView;

                // W3C standard way:
                if (defaultView && defaultView.getComputedStyle) {
                    // sanitize property name to css notation
                    // (hyphen separated words eg. font-Size)
                    styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();

                    return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
                } else if (el.currentStyle) { // IE
                    // sanitize property name to camelCase
                    styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
                        return letter.toUpperCase();
                    });

                    value = el.currentStyle[styleProp];

                    // convert other units to pixels on IE
                    if (/^\d+(em|pt|%|ex)?$/i.test(value)) {
                        return (function(value) {
                            var oldLeft = el.style.left, oldRsLeft = el.runtimeStyle.left;

                            el.runtimeStyle.left = el.currentStyle.left;
                            el.style.left = value || 0;
                            value = el.style.pixelLeft + "px";
                            el.style.left = oldLeft;
                            el.runtimeStyle.left = oldRsLeft;

                            return value;
                        })(value);
                    }

                    return value;
                }
            }
        },

        slide: function(el, dir, speed, callback, recalcMaxHeight) {
            if (!el || (dir == 'up' && TI_Util.visible(el) === false) || (dir == 'down' && TI_Util.visible(el) === true)) {
                return;
            }

            speed = (speed ? speed : 600);
            var calcHeight = TI_Util.actualHeight(el);
            var calcPaddingTop = false;
            var calcPaddingBottom = false;

            if (TI_Util.css(el, 'padding-top') && TI_Util.data(el).has('slide-padding-top') !== true) {
                TI_Util.data(el).set('slide-padding-top', TI_Util.css(el, 'padding-top'));
            }

            if (TI_Util.css(el, 'padding-bottom') && TI_Util.data(el).has('slide-padding-bottom') !== true) {
                TI_Util.data(el).set('slide-padding-bottom', TI_Util.css(el, 'padding-bottom'));
            }

            if (TI_Util.data(el).has('slide-padding-top')) {
                calcPaddingTop = parseInt(TI_Util.data(el).get('slide-padding-top'));
            }

            if (TI_Util.data(el).has('slide-padding-bottom')) {
                calcPaddingBottom = parseInt(TI_Util.data(el).get('slide-padding-bottom'));
            }

            if (dir == 'up') { // up
                el.style.cssText = 'display: block; overflow: hidden;';

                if (calcPaddingTop) {
                    TI_Util.animate(0, calcPaddingTop, speed, function(value) {
                        el.style.paddingTop = (calcPaddingTop - value) + 'px';
                    }, 'linear');
                }

                if (calcPaddingBottom) {
                    TI_Util.animate(0, calcPaddingBottom, speed, function(value) {
                        el.style.paddingBottom = (calcPaddingBottom - value) + 'px';
                    }, 'linear');
                }

                TI_Util.animate(0, calcHeight, speed, function(value) {
                    el.style.height = (calcHeight - value) + 'px';
                }, 'linear', function() {
                    el.style.height = '';
                    el.style.display = 'none';

                    if (typeof callback === 'function') {
                        callback();
                    }
                });


            } else if (dir == 'down') { // down
                el.style.cssText = 'display: block; overflow: hidden;';

                if (calcPaddingTop) {
                    TI_Util.animate(0, calcPaddingTop, speed, function(value) {//
                        el.style.paddingTop = value + 'px';
                    }, 'linear', function() {
                        el.style.paddingTop = '';
                    });
                }

                if (calcPaddingBottom) {
                    TI_Util.animate(0, calcPaddingBottom, speed, function(value) {
                        el.style.paddingBottom = value + 'px';
                    }, 'linear', function() {
                        el.style.paddingBottom = '';
                    });
                }

                TI_Util.animate(0, calcHeight, speed, function(value) {
                    el.style.height = value + 'px';
                }, 'linear', function() {
                    el.style.height = '';
                    el.style.display = '';
                    el.style.overflow = '';

                    if (typeof callback === 'function') {
                        callback();
                    }
                });
            }
        },

        slideUp: function(el, speed, callback) {
            TI_Util.slide(el, 'up', speed, callback);
        },

        slideDown: function(el, speed, callback) {
            TI_Util.slide(el, 'down', speed, callback);
        },

        show: function(el, display) {
            if (typeof el !== 'undefined') {
                el.style.display = (display ? display : 'block');
            }
        },

        hide: function(el) {
            if (typeof el !== 'undefined') {
                el.style.display = 'none';
            }
        },

        addEvent: function(el, type, handler, one) {
            if (typeof el !== 'undefined' && el !== null) {
                el.addEventListener(type, handler);
            }
        },

        removeEvent: function(el, type, handler) {
            if (el !== null) {
                el.removeEventListener(type, handler);
            }
        },

        on: function(element, selector, event, handler) {
            if ( element === null ) {
                return;
            }

            var eventId = TI_Util.getUniqueId('event');

            window.TI_UtilDelegatedEventHandlers[eventId] = function(e) {
                var targets = element.querySelectorAll(selector);
                var target = e.target;

                while ( target && target !== element ) {
                    for ( var i = 0, j = targets.length; i < j; i++ ) {
                        if ( target === targets[i] ) {
                            handler.call(target, e);
                        }
                    }

                    target = target.parentNode;
                }
            }

            TI_Util.addEvent(element, event, window.TI_UtilDelegatedEventHandlers[eventId]);

            return eventId;
        },

        off: function(element, event, eventId) {
            if (!element || !window.TI_UtilDelegatedEventHandlers[eventId]) {
                return;
            }

            TI_Util.removeEvent(element, event, window.TI_UtilDelegatedEventHandlers[eventId]);

            delete window.TI_UtilDelegatedEventHandlers[eventId];
        },

        one: function onetime(el, type, callback) {
            el.addEventListener(type, function callee(e) {
                // remove event
                if (e.target && e.target.removeEventListener) {
                    e.target.removeEventListener(e.type, callee);
                }

                // need to verify from https://themeforest.net/author_dashboard#comment_23615588
                if (el && el.removeEventListener) {
				    e.currentTarget.removeEventListener(e.type, callee);
			    }

                // call handler
                return callback(e);
            });
        },

        hash: function(str) {
            var hash = 0,
                i, chr;

            if (str.length === 0) return hash;
            for (i = 0; i < str.length; i++) {
                chr = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + chr;
                hash |= 0; // Convert to 32bit integer
            }

            return hash;
        },

        animateClass: function(el, animationName, callback) {
            var animation;
            var animations = {
                animation: 'animationend',
                OAnimation: 'oAnimationEnd',
                MozAnimation: 'mozAnimationEnd',
                WebkitAnimation: 'webkitAnimationEnd',
                msAnimation: 'msAnimationEnd',
            };

            for (var t in animations) {
                if (el.style[t] !== undefined) {
                    animation = animations[t];
                }
            }

            TI_Util.addClass(el, animationName);

            TI_Util.one(el, animation, function() {
                TI_Util.removeClass(el, animationName);
            });

            if (callback) {
                TI_Util.one(el, animation, callback);
            }
        },

        transitionEnd: function(el, callback) {
            var transition;
            var transitions = {
                transition: 'transitionend',
                OTransition: 'oTransitionEnd',
                MozTransition: 'mozTransitionEnd',
                WebkitTransition: 'webkitTransitionEnd',
                msTransition: 'msTransitionEnd'
            };

            for (var t in transitions) {
                if (el.style[t] !== undefined) {
                    transition = transitions[t];
                }
            }

            TI_Util.one(el, transition, callback);
        },

        animationEnd: function(el, callback) {
            var animation;
            var animations = {
                animation: 'animationend',
                OAnimation: 'oAnimationEnd',
                MozAnimation: 'mozAnimationEnd',
                WebkitAnimation: 'webkitAnimationEnd',
                msAnimation: 'msAnimationEnd'
            };

            for (var t in animations) {
                if (el.style[t] !== undefined) {
                    animation = animations[t];
                }
            }

            TI_Util.one(el, animation, callback);
        },

        animateDelay: function(el, value) {
            var vendors = ['webkit-', 'moz-', 'ms-', 'o-', ''];
            for (var i = 0; i < vendors.length; i++) {
                TI_Util.css(el, vendors[i] + 'animation-delay', value);
            }
        },

        animateDuration: function(el, value) {
            var vendors = ['webkit-', 'moz-', 'ms-', 'o-', ''];
            for (var i = 0; i < vendors.length; i++) {
                TI_Util.css(el, vendors[i] + 'animation-duration', value);
            }
        },

        scrollTo: function(target, offset, duration) {
            var duration = duration ? duration : 500;
            var targetPos = target ? TI_Util.offset(target).top : 0;
            var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            var from, to;

            if (offset) {
                targetPos = targetPos - offset;
            }

            from = scrollPos;
            to = targetPos;

            TI_Util.animate(from, to, duration, function(value) {
                document.documentElement.scrollTop = value;
                document.body.parentNode.scrollTop = value;
                document.body.scrollTop = value;
            }); //, easing, done
        },

        scrollTop: function(offset, duration) {
            TI_Util.scrollTo(null, offset, duration);
        },

        isArray: function(obj) {
            return obj && Array.isArray(obj);
        },

        isEmpty: function(obj) {
            for (var prop in obj) {
                if (obj.hasOwnProperty(prop)) {
                    return false;
                }
            }

            return true;
        },

        numberString: function(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        },

        isRTL: function() {
            return (document.querySelector('html').getAttribute("direction") === 'rtl');
        },

        snakeToCamel: function(s){
            return s.replace(/(\-\w)/g, function(m){return m[1].toUpperCase();});
        },

        filterBoolean: function(val) {
            // Convert string boolean
			if (val === true || val === 'true') {
				return true;
			}

			if (val === false || val === 'false') {
				return false;
			}

            return val;
        },

        setHTML: function(el, html) {
            el.innerHTML = html;
        },

        getHTML: function(el) {
            if (el) {
                return el.innerHTML;
            }
        },

        getDocumentHeight: function() {
            var body = document.body;
            var html = document.documentElement;

            return Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
        },

        getScrollTop: function() {
            return  (document.scrollingElement || document.documentElement).scrollTop;
        },

        colorLighten: function(color, amount) {
            const addLight = function(color, amount){
                let cc = parseInt(color,16) + amount;
                let c = (cc > 255) ? 255 : (cc);
                c = (c.toString(16).length > 1 ) ? c.toString(16) : `0${c.toString(16)}`;
                return c;
            }

            color = (color.indexOf("#")>=0) ? color.substring(1,color.length) : color;
            amount = parseInt((255*amount)/100);

            return color = `#${addLight(color.substring(0,2), amount)}${addLight(color.substring(2,4), amount)}${addLight(color.substring(4,6), amount)}`;
        },

        colorDarken: function(color, amount) {
            const subtractLight = function(color, amount){
                let cc = parseInt(color,16) - amount;
                let c = (cc < 0) ? 0 : (cc);
                c = (c.toString(16).length > 1 ) ? c.toString(16) : `0${c.toString(16)}`;

                return c;
            }

            color = (color.indexOf("#")>=0) ? color.substring(1,color.length) : color;
            amount = parseInt((255*amount)/100);

            return color = `#${subtractLight(color.substring(0,2), amount)}${subtractLight(color.substring(2,4), amount)}${subtractLight(color.substring(4,6), amount)}`;
        },

        // Throttle function: Input as function which needs to be throttled and delay is the time interval in milliseconds
        throttle:  function (timer, func, delay) {
        	// If setTimeout is already scheduled, no need to do anything
        	if (timer) {
        		return;
        	}

        	// Schedule a setTimeout after delay seconds
        	timer  =  setTimeout(function () {
        		func();

        		// Once setTimeout function execution is finished, timerId = undefined so that in <br>
        		// the next scroll event function execution can be scheduled by the setTimeout
        		timer  =  undefined;
        	}, delay);
        },

        // Debounce function: Input as function which needs to be debounced and delay is the debounced time in milliseconds
        debounce: function (timer, func, delay) {
        	// Cancels the setTimeout method execution
        	clearTimeout(timer)

        	// Executes the func after delay time.
        	timer  =  setTimeout(func, delay);
        },

        parseJson: function(value) {
            if (typeof value === 'string') {
                value = value.replace(/'/g, "\"");

                var jsonStr = value.replace(/(\w+:)|(\w+ :)/g, function(matched) {
                    return '"' + matched.substring(0, matched.length - 1) + '":';
                });

                try {
                    value = JSON.parse(jsonStr);
                } catch(e) { }
            }

            return value;
        },

        getResponsiveValue: function(value, defaultValue) {
            var width = this.getViewPort().width;
            var result = null;

            value = TI_Util.parseJson(value);

            if (typeof value === 'object') {
                var resultKey;
                var resultBreakpoint = -1;
                var breakpoint;

                for (var key in value) {
                    if (key === 'default') {
                        breakpoint = 0;
                    } else {
                        breakpoint = this.getBreakpoint(key) ? this.getBreakpoint(key) : parseInt(key);
                    }

                    if (breakpoint <= width && breakpoint > resultBreakpoint) {
                        resultKey = key;
                        resultBreakpoint = breakpoint;
                    }
                }

                if (resultKey) {
                    result = value[resultKey];
                } else {
                    result = value;
                }
            } else {
                result = value;
            }

            return result;
        },

        each: function(array, callback) {
            return [].slice.call(array).map(callback);
        },

        getSelectorMatchValue: function(value) {
            var result = null;
            value = TI_Util.parseJson(value);

            if ( typeof value === 'object' ) {
                // Match condition
                if ( value['match'] !== undefined ) {
                    var selector = Object.keys(value['match'])[0];
                    value = Object.values(value['match'])[0];

                    if ( document.querySelector(selector) !== null ) {
                        result = value;
                    }
                }
            } else {
                result = value;
            }

            return result;
        },

        getConditionalValue: function(value) {
            var value = TI_Util.parseJson(value);
            var result = TI_Util.getResponsiveValue(value);

            if ( result !== null && result['match'] !== undefined ) {
                result = TI_Util.getSelectorMatchValue(result);
            }

            if ( result === null && value !== null && value['default'] !== undefined ) {
                result = value['default'];
            }

            return result;
        },

        getCssVariableValue: function(variableName) {
            var hex = getComputedStyle(document.documentElement).getPropertyValue(variableName);
            if ( hex && hex.length > 0 ) {
                hex = hex.trim();
            }

            return hex;
        },

        isInViewport: function(element) {
            var rect = element.getBoundingClientRect();

            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        },

        isPartiallyInViewport: function(element) {
            let x = element.getBoundingClientRect().left;
            let y = element.getBoundingClientRect().top;
            let ww = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
            let hw = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
            let w = element.clientWidth;
            let h = element.clientHeight;

            return (
                (y < hw &&
                y + h > 0) &&
                (x < ww &&
                x + w > 0)
            );
        },

        onDOMContentLoaded: function(callback) {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', callback);
            } else {
                callback();
            }
        },

        inIframe: function() {
            try {
                return window.self !== window.top;
            } catch (e) {
                return true;
            }
        },

        isHexColor(code) {
            return /^#[0-9A-F]{6}$/i.test(code);
        }
    }
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_Util;
}
"use strict";

// Class definition
var TI_AppLayoutBuilder = function() {
	var form;
	var actionInput;
	var url;
	var previewButton;
	var exportButton;
	var resetButton;

	var engage;
	var engageToggleOff;
	var engageToggleOn;
	var engagePrebuiltsModal;

	var handleEngagePrebuilts = function() {
		if (engagePrebuiltsModal === null) {
			return;
		}

		if ( TI_Cookie.get("app_engage_prebuilts_modal_displayed") !== "1" ) {
			setTimeout(function() {
				const modal = new bootstrap.Modal(engagePrebuiltsModal);
				modal.show();

				const date = new Date(Date.now() + 30 * 24 * 60 * 60 * 1000); // 30 days from now
				TI_Cookie.set("app_engage_prebuilts_modal_displayed", "1", {expires: date});
			}, 3000);
		}
	}

	var handleEngagePrebuiltsViewMenu = function() {
		const selected = engagePrebuiltsModal.querySelector('[data-ti-element="selected"]');
		const selectedTitle = engagePrebuiltsModal.querySelector('[data-ti-element="title"]');
		const menu = engagePrebuiltsModal.querySelector('[data-ti-menu="true"]');

		// Toggle Handler
		TI_Util.on(engagePrebuiltsModal, '[data-ti-mode]', 'click', function (e) {
			const title = this.innerText;
			const mode = this.getAttribute("data-ti-mode");
			const selectedLink = menu.querySelector('.menu-link.active');
			const viewImage = document.querySelector('#ti_app_engage_prebuilts_view_image');
			const viewText = document.querySelector('#ti_app_engage_prebuilts_view_text');
			selectedTitle.innerText = title;

			if (selectedLink) {
				selectedLink.classList.remove('active');
			}

			this.classList.add('active');

			if (mode === "image") {
				viewImage.classList.remove("d-none");
				viewImage.classList.add("d-block");
				viewText.classList.remove("d-block");
				viewText.classList.add("d-none");
			} else {
				viewText.classList.remove("d-none");
				viewText.classList.add("d-block");
				viewImage.classList.remove("d-block");
				viewImage.classList.add("d-none");
			}
		});
	}

	var handleEngageToggle = function() {
		engageToggleOff.addEventListener("click", function (e) {
			e.preventDefault();

			const date = new Date(Date.now() + 1 * 24 * 60 * 60 * 1000); // 1 days from now
			TI_Cookie.set("app_engage_hide", "1", {expires: date});
			engage.classList.add('app-engage-hide');
		});

		engageToggleOn.addEventListener("click", function (e) {
			e.preventDefault();

			TI_Cookie.remove("app_engage_hide");
			engage.classList.remove('app-engage-hide');
		});
	}

	var handlePreview = function() {
		previewButton.addEventListener("click", function(e) {
			e.preventDefault();

			// Set form action value
			actionInput.value = "preview";

			// Show progress
			previewButton.setAttribute("data-ti-indicator", "on");

			// Prepare form data
			var data = $(form).serialize();

			// Submit
			$.ajax({
				type: "POST",
				dataType: "html",
				url: url,
				data: data,
				success: function(response, status, xhr) {
					if (history.scrollRestoration) {
						history.scrollRestoration = 'manual';
					}
					location.reload();
					return;

					toastr.success(
						"Preview has been updated with current configured layout.",
						"Preview updated!",
						{timeOut: 0, extendedTimeOut: 0, closeButton: true, closeDuration: 0}
					);

					setTimeout(function() {
						location.reload(); // reload page
					}, 1500);
				},
				error: function(response) {
					toastr.error(
						"Please try it again later.",
						"Something went wrong!",
						{timeOut: 0, extendedTimeOut: 0, closeButton: true, closeDuration: 0}
					);
				},
				complete: function() {
					previewButton.removeAttribute("data-ti-indicator");
				}
			});
		});
	};

	var handleExport = function() {
		exportButton.addEventListener("click", function(e) {
			e.preventDefault();

			toastr.success(
				"Process has been started and it may take a while.",
				"Generating HTML!",
				{timeOut: 0, extendedTimeOut: 0, closeButton: true, closeDuration: 0}
			);

			// Show progress
			exportButton.setAttribute("data-ti-indicator", "on");

			// Set form action value
			actionInput.value = "export";

			// Prepare form data
			var data = $(form).serialize();

			$.ajax({
				type: "POST",
				dataType: "html",
				url: url,
				data: data,
				success: function(response, status, xhr) {
					var timer = setInterval(function() {
						$("<iframe/>").attr({
							src: url + "?layout-builder[action]=export&download=1&output=" + response,
							style: "visibility:hidden;display:none",
						}).ready(function() {
							// Stop the timer
							clearInterval(timer);

							exportButton.removeAttribute("data-ti-indicator");
						}).appendTo("body");
					}, 3000);
				},
				error: function(response) {
					toastr.error(
						"Please try it again later.",
						"Something went wrong!",
						{timeOut: 0, extendedTimeOut: 0, closeButton: true, closeDuration: 0}
					);

					exportButton.removeAttribute("data-ti-indicator");
				},
			});
		});
	};

	var handleReset = function() {
		resetButton.addEventListener("click", function(e) {
			e.preventDefault();

			// Show progress
			resetButton.setAttribute("data-ti-indicator", "on");

			// Set form action value
			actionInput.value = "reset";

			// Prepare form data
			var data = $(form).serialize();

			$.ajax({
				type: "POST",
				dataType: "html",
				url: url,
				data: data,
				success: function(response, status, xhr) {
					if (history.scrollRestoration) {
						history.scrollRestoration = 'manual';
					}

					location.reload();
					return;

					toastr.success(
						"Preview has been successfully reset and the page will be reloaded.",
						"Reset Preview!",
						{timeOut: 0, extendedTimeOut: 0, closeButton: true, closeDuration: 0}
					);

					setTimeout(function() {
						location.reload(); // reload page
					}, 1500);
				},
				error: function(response) {
					toastr.error(
						"Please try it again later.",
						"Something went wrong!",
						{timeOut: 0, extendedTimeOut: 0, closeButton: true, closeDuration: 0}
					);
				},
				complete: function() {
					resetButton.removeAttribute("data-ti-indicator");
				},
			});
		});
	};

	var handleThemeMode = function() {
		var checkLight = document.querySelector('#ti_layout_builder_theme_mode_light');
		var checkDark = document.querySelector('#ti_layout_builder_theme_mode_dark');
		var check = document.querySelector('#ti_layout_builder_theme_mode_' + TI_ThemeMode.getMode());

		if (checkLight) {
			checkLight.addEventListener("click", function() {
				this.checked = true;
				this.closest('[data-ti-buttons="true"]').querySelector('.form-check-image.active').classList.remove('active');
				this.closest('.form-check-image').classList.add('active');
				TI_ThemeMode.setMode('light');
			});
		}

		if (checkDark) {
			checkDark.addEventListener("click", function() {
				this.checked = true;
				this.closest('[data-ti-buttons="true"]').querySelector('.form-check-image.active').classList.remove('active');
				this.closest('.form-check-image').classList.add('active');
				TI_ThemeMode.setMode('dark');
			});
		}

		if ( check ) {
			check.closest('.form-check-image').classList.add('active');
			check.checked = true;
		}
	}

	return {
		// Public functions
		init: function() {
			engage = document.querySelector('#ti_app_engage');
			engageToggleOn = document.querySelector('#ti_app_engage_toggle_on');
			engageToggleOff = document.querySelector('#ti_app_engage_toggle_off');
			engagePrebuiltsModal = document.querySelector('#ti_app_engage_prebuilts_modal');

			if ( engage && engagePrebuiltsModal) {
				handleEngagePrebuilts();
				handleEngagePrebuiltsViewMenu();
			}

			if ( engage && engageToggleOn && engageToggleOff ) {
				handleEngageToggle();
			}

            form = document.querySelector("#ti_app_layout_builder_form");

            if ( !form ) {
                return;
            }

            url = form.getAttribute("action");
            actionInput = document.querySelector("#ti_app_layout_builder_action");
            previewButton = document.querySelector("#ti_app_layout_builder_preview");
            exportButton = document.querySelector("#ti_app_layout_builder_export");
            resetButton = document.querySelector("#ti_app_layout_builder_reset");

			if ( previewButton ) {
				handlePreview();
			}

			if ( exportButton ) {
				handleExport();
			}

			if ( resetButton ) {
				handleReset();
			}

			handleThemeMode();
		}
	};
}();

// On document ready
TI_Util.onDOMContentLoaded(function() {
    TI_AppLayoutBuilder.init();
});
// "use strict";
//
// // Class definition
// var TI_LayoutSearch = function() {
//     // Private variables
//     var element;
//     var formElement;
//     var mainElement;
//     var resultsElement;
//     var wrapperElement;
//     var emptyElement;
//
//     var preferencesElement;
//     var preferencesShowElement;
//     var preferencesDismissElement;
//
//     var advancedOptionsFormElement;
//     var advancedOptionsFormShowElement;
//     var advancedOptionsFormCancelElement;
//     var advancedOptionsFormSearchElement;
//
//     var searchObject;
//
//     // Private functions
//     var processs = function(search) {
//         var timeout = setTimeout(function() {
//             var number = TI_Util.getRandomInt(1, 3);
//
//             // Hide recently viewed
//             mainElement.classList.add('d-none');
//
//             if (number === 3) {
//                 // Hide results
//                 resultsElement.classList.add('d-none');
//                 // Show empty message
//                 emptyElement.classList.remove('d-none');
//             } else {
//                 // Show results
//                 resultsElement.classList.remove('d-none');
//                 // Hide empty message
//                 emptyElement.classList.add('d-none');
//             }
//
//             // Complete search
//             search.complete();
//         }, 1500);
//     }
//
//     var processsAjax = function(search) {
//         // Hide recently viewed
//         mainElement.classList.add('d-none');
//
//         // Learn more: https://axios-http.com/docs/intro
//         axios.post('/search.php', {
//             query: searchObject.getQuery()
//         })
//         .then(function (response) {
//             // Populate results
//             resultsElement.innerHTML = response;
//             // Show results
//             resultsElement.classList.remove('d-none');
//             // Hide empty message
//             emptyElement.classList.add('d-none');
//
//             // Complete search
//             search.complete();
//         })
//         .catch(function (error) {
//             // Hide results
//             resultsElement.classList.add('d-none');
//             // Show empty message
//             emptyElement.classList.remove('d-none');
//
//             // Complete search
//             search.complete();
//         });
//     }
//
//     var clear = function(search) {
//         // Show recently viewed
//         mainElement.classList.remove('d-none');
//         // Hide results
//         resultsElement.classList.add('d-none');
//         // Hide empty message
//         emptyElement.classList.add('d-none');
//     }
//
//     var handlePreferences = function() {
//         // Preference show handler
//         preferencesShowElement.addEventListener('click', function() {
//             wrapperElement.classList.add('d-none');
//             preferencesElement.classList.remove('d-none');
//         });
//
//         // Preference dismiss handler
//         preferencesDismissElement.addEventListener('click', function() {
//             wrapperElement.classList.remove('d-none');
//             preferencesElement.classList.add('d-none');
//         });
//     }
//
//     var handleAdvancedOptionsForm = function() {
//         // Show
//         advancedOptionsFormShowElement.addEventListener('click', function() {
//             wrapperElement.classList.add('d-none');
//             advancedOptionsFormElement.classList.remove('d-none');
//         });
//
//         // Cancel
//         advancedOptionsFormCancelElement.addEventListener('click', function() {
//             wrapperElement.classList.remove('d-none');
//             advancedOptionsFormElement.classList.add('d-none');
//         });
//
//         // Search
//         advancedOptionsFormSearchElement.addEventListener('click', function() {
//
//         });
//     }
//
//     // Public methods
// 	return {
// 		init: function() {
//             // Elements
//             element = document.querySelector('#ti_header_search');
//
//             if (!element) {
//                 return;
//             }
//
//             wrapperElement = element.querySelector('[data-ti-search-element="wrapper"]');
//             formElement = element.querySelector('[data-ti-search-element="form"]');
//             mainElement = element.querySelector('[data-ti-search-element="main"]');
//             resultsElement = element.querySelector('[data-ti-search-element="results"]');
//             emptyElement = element.querySelector('[data-ti-search-element="empty"]');
//
//             preferencesElement = element.querySelector('[data-ti-search-element="preferences"]');
//             preferencesShowElement = element.querySelector('[data-ti-search-element="preferences-show"]');
//             preferencesDismissElement = element.querySelector('[data-ti-search-element="preferences-dismiss"]');
//
//             advancedOptionsFormElement = element.querySelector('[data-ti-search-element="advanced-options-form"]');
//             advancedOptionsFormShowElement = element.querySelector('[data-ti-search-element="advanced-options-form-show"]');
//             advancedOptionsFormCancelElement = element.querySelector('[data-ti-search-element="advanced-options-form-cancel"]');
//             advancedOptionsFormSearchElement = element.querySelector('[data-ti-search-element="advanced-options-form-search"]');
//
//             // Initialize search handler
//             searchObject = new TI_Search(element);
//
//             // Demo search handler
//             searchObject.on('ti.search.process', processs);
//
//             // Ajax search handler
//             //searchObject.on('ti.search.process', processsAjax);
//
//             // Clear handler
//             searchObject.on('ti.search.clear', clear);
//
//             // Custom handlers
//             handlePreferences();
//             handleAdvancedOptionsForm();
// 		}
// 	};
// }();
//
// // On document ready
// TI_Util.onDOMContentLoaded(function() {
//     TI_LayoutSearch.init();
// });
"use strict";

// Class definition
var TI_AppSidebar = function () {
	// Private variables
	var navWrapper;
	var projectsCollapse;
	var header;

	var handleMenuScroll = function() {
		var menuActiveItem = navWrapper.querySelector(".menu-link.active");

		if ( !menuActiveItem ) {
			return;
		}

		if ( TI_Util.isVisibleInContainer(menuActiveItem, navWrapper) === true) {
			return;
		}

		navWrapper.scroll({
			top: TI_Util.getRelativeTopPosition(menuActiveItem, navWrapper),
			behavior: 'smooth'
		});
	}

	var handleProjectsCollapse = function() {
		projectsCollapse.addEventListener('shown.bs.collapse', event => {
			const scrollHeight = parseInt(TI_Util.css(navWrapper, "height"));
			navWrapper.scroll({
				top: scrollHeight,
				behavior: 'smooth'
			});
		})
	}

	var handleProjectsSelection = function() {
		const selected = header.querySelector('[data-ti-element="selected"]');
		const menu = header.querySelector('[data-ti-menu="true"]');

		// Toggle Handler
		TI_Util.on(header, '[data-ti-element="project"]', 'click', function (e) {
			const logo = this.querySelector('[data-ti-element="logo"]');
			const title = this.querySelector('[data-ti-element="title"]');
			const desc = this.querySelector('[data-ti-element="desc"]');
			const selectedLink = menu.querySelector('.menu-link.active');

			selected.querySelector('[data-ti-element="logo"]').setAttribute("src", logo.getAttribute("src"));
			selected.querySelector('[data-ti-element="title"]').innerText = title.innerText;
			selected.querySelector('[data-ti-element="desc"]').innerText = desc.innerText;

			if (selectedLink) {
				selectedLink.classList.remove('active');
			}

			this.classList.add('active');
		});
	}

	// Public methods
	return {
		init: function () {
			// Elements
			navWrapper = document.querySelector('#ti_app_sidebar_main_wrappers');
			projectsCollapse = document.querySelector('#ti_app_sidebar_menu_projects_collapse');
			header = document.querySelector('#ti_app_sidebar_header');

			if ( navWrapper ) {
				handleMenuScroll();
			}

			if ( projectsCollapse ) {
				handleProjectsCollapse();
			}

			if ( header ) {
				handleProjectsSelection();
			}
		}
	};
}();

// On document ready
TI_Util.onDOMContentLoaded(function () {
	TI_AppSidebar.init();
});
"use strict";

// Class definition
var TI_ThemeModeUser = function () {

    var handleSubmit = function() {
		// Update chart on theme mode change
        TI_ThemeMode.on("ti.thememode.change", function() {
            var menuMode = TI_ThemeMode.getMenuMode();
            var mode = TI_ThemeMode.getMode();
            console.log("user selected theme mode:" + menuMode);
            console.log("theme mode:" + mode);

            // Submit selected theme mode menu option via ajax and
            // store it in user profile and set the user opted theme mode via HTML attribute
            // <html data-theme-mode="light"> .... </html>
        });
    }

    return {
        init: function () {
			handleSubmit();
        }
    };
}();

// Initialize app on document ready
TI_Util.onDOMContentLoaded(function () {
    TI_ThemeModeUser.init();
});

// Declare TI_ThemeModeUser for Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_ThemeModeUser;
}
"use strict";

// Class definition
var TI_ThemeMode = function () {
	var menu;
	var callbacks = [];
	var the = this;

    var getMode = function() {
		var mode;

		if ( document.documentElement.hasAttribute("data-bs-theme") ) {
            return document.documentElement.getAttribute("data-bs-theme");
        } else if ( localStorage.getItem("data-bs-theme") !== null ) {
			return localStorage.getItem("data-bs-theme");
		} else if ( getMenuMode() === "system" ) {
			return getSystemMode();
		}

        return "light";
    }

    var setMode = function(mode, menuMode) {
		var currentMode = getMode();

		// Reset mode if system mode was changed
		if ( menuMode === 'system') {
			if ( getSystemMode() !==  mode ) {
				mode = getSystemMode();
			}
		} else if (mode !== menuMode) {
			menuMode = mode;
		}

		// Read active menu mode value
		var activeMenuItem = menu ? menu.querySelector('[data-ti-element="mode"][data-ti-value="' + menuMode + '"]') : null;

		// Enable switching state
		document.documentElement.setAttribute("data-ti-theme-mode-switching", "true");

		// Set mode to the target document.documentElement
		document.documentElement.setAttribute("data-bs-theme", mode);

		// Disable switching state
		setTimeout(function() {
			document.documentElement.removeAttribute("data-ti-theme-mode-switching");
		}, 300);

		// Store mode value in storage
        localStorage.setItem("data-bs-theme", mode);

		// Set active menu item
		if ( activeMenuItem ) {
			localStorage.setItem("data-bs-theme-mode", menuMode);
			setActiveMenuItem(activeMenuItem);
		}

		if (mode !== currentMode) {
			TI_EventHandler.trigger(document.documentElement, 'ti.thememode.change', the);
		}
    }

	var getMenuMode = function() {
		if (!menu) {
			return null;
		}

		var menuItem = menu ? menu.querySelector('.active[data-ti-element="mode"]') : null;

		if ( menuItem && menuItem.getAttribute('data-ti-value') ) {
            return menuItem.getAttribute('data-ti-value');
        } else if ( document.documentElement.hasAttribute("data-bs-theme-mode") ) {
			return document.documentElement.getAttribute("data-bs-theme-mode")
		} else if ( localStorage.getItem("data-bs-theme-mode") !== null ) {
			return localStorage.getItem("data-bs-theme-mode");
		} else {
			return typeof defaultThemeMode !== "undefined" ? defaultThemeMode : "light";
		}
	}

	var getSystemMode = function() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? "dark" : "light";
    }

	var initMode = function() {
		setMode(getMode(), getMenuMode());
		TI_EventHandler.trigger(document.documentElement, 'ti.thememode.init', the);
	}

	var getActiveMenuItem = function() {
		return menu.querySelector('[data-ti-element="mode"][data-ti-value="' + getMenuMode() + '"]');
	}

	var setActiveMenuItem = function(item) {
		var menuMode = item.getAttribute("data-ti-value");

		var activeItem = menu.querySelector('.active[data-ti-element="mode"]');

		if ( activeItem ) {
			activeItem.classList.remove("active");
		}

		item.classList.add("active");
		localStorage.setItem("data-bs-theme-mode", menuMode);
	}

	var handleMenu = function() {
		var items = [].slice.call(menu.querySelectorAll('[data-ti-element="mode"]'));

        items.map(function (item) {
            item.addEventListener("click", function(e) {
				e.preventDefault();

				var menuMode = item.getAttribute("data-ti-value");
				var mode = menuMode;

				if ( menuMode === "system") {
					mode = getSystemMode();
				}

				setMode(mode, menuMode);
			});
        });
	}

    return {
        init: function () {
			menu = document.querySelector('[data-ti-element="theme-mode-menu"]');

            initMode();

			if (menu) {
				handleMenu();
			}
        },

        getMode: function () {
            return getMode();
        },

		getMenuMode: function() {
			return getMenuMode();
		},

		getSystemMode: function () {
            return getSystemMode();
        },

        setMode: function(mode) {
            return setMode(mode)
        },

		on: function(name, handler) {
			return TI_EventHandler.on(document.documentElement, name, handler);
		},

		off: function(name, handlerId) {
			return TI_EventHandler.off(document.documentElement, name, handlerId);
		}
    };
}();

// Initialize app on document ready
TI_Util.onDOMContentLoaded(function () {
    TI_ThemeMode.init();
});

// Declare TI_ThemeMode for Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = TI_ThemeMode;
}
//# sourceMappingURL=scripts.bundle.js.map
