var TI_Select = function() {
    var initLeadStatusSelect = function() {
        const elements = document.getElementsByClassName('lead_status_select');
        if (elements.length === 0) {
            return;
        }

        Object.entries(elements).forEach(function([index, el]) {
            // Init on load
            var selectedColor = el.options[el.selectedIndex].getAttribute('data-color');
            var classes = el.className.split(' ');
            classes.push('bg-' + selectedColor);
            classes.push('bg-opacity-20');
            classes.push('border-' + selectedColor);
            classes.push('text-' + selectedColor);
            el.className = classes.join(' ');

            el.addEventListener('change', function() {
                var color = el.options[el.selectedIndex].getAttribute('data-color');
                // Change select color
                var classes = el.className.split(' ').map(function(item_class) {
                    return item_class.startsWith('bg-') || item_class.startsWith('border-') || item_class.startsWith('text-') ? '' : item_class;
                }).filter(function(item) {
                    return item !== '';
                });
                classes.push('bg-' + color);
                classes.push('bg-opacity-20');
                classes.push('border-' + color);
                classes.push('text-' + color);
                el.className = classes.join(' ');
            });
        });
    }

    return {
        init: function() {
            initLeadStatusSelect();
        }
    }
}();
// On document ready
TI_Util.onDOMContentLoaded(function () {
	TI_Select.init();
});
//# sourceMappingURL=select.js.map
