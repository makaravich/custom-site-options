function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

docReady(function () {
    initialPropertiesList();
    updateSorting();
    //console.log('Admin script Ok');
});

function updateSorting() {
    sortable('.sortable')[0].addEventListener('sortupdate', initialPropertiesList);
}

function initialPropertiesList() {
    //console.log('Before sorting');
    let items = document.querySelectorAll('.sortable .single-field');
    let index = 0;
    let condition;

    if (items) {
        let fields;

        for (let i = 0, len = items.length; i < len; i++) {
            fields = items[i].querySelectorAll('.property-field');
            //console.log(fields);

            for (let j = 0, len = fields.length; j < len; j++) {
                fields[j].name = getUpdatedFieldName(fields[j].name, index);
            }

            //Process conditional fields
            for (let j = 0, len = fields.length; j < len; j++) {

                //if (fields[j].data)
                condition = jQuery(fields[j]).closest('.single-property').data('condition');
                //console.log(condition);
                if (condition !== undefined) {
                    setConditionTrigger(fields[j], condition);
                }
            }
            index++;
        }
        //console.log('Sorted');
    }
}

function getUpdatedFieldName(name, index) {
    const regex = /\[[0-9]+\]/gm;
    const subst = `[` + index + `]`;

    // The substituted value will be contained in the result variable
    return name.replace(regex, subst);
}

function addNewField(fieldName) {
    let index = jQuery('.fields-container ul').length-1;
    //console.log(index);

    jQuery.ajax({
        url: cg_general['url'],
        type: 'post',
        data: {
            action: 'get_default_field',
            index: index,
            field_name: fieldName,
        },

        success: function (response) {
            if (response) {
                // console.log(response)
                jQuery('.fields-container .sortable').append(response);
                initialPropertiesList();
                updateSorting();
            }
        },
        error: function (response) {
            console.log("Error: " + JSON.stringify(response));
        },

    });
}

function deletePropertyItem(sender) {
    // console.log(sender);
    if (confirm('Do you really want to remove this field?')) {
        jQuery(sender).closest('.single-field').remove();
        updateSorting();
    }
}

function openCloseProperty(sender) {
    let property = jQuery(sender).closest('.single-field');
    if (property.hasClass('collapsed')) {
        property.removeClass('collapsed')
    } else {
        property.addClass('collapsed');
    }
}

function setConditionTrigger(sender, condition) {
    let commonName, triggerFieldName;
    let triggerElement;

    commonName = jQuery(sender).closest('.single-field').data('commonName');

    triggerFieldName = commonName + "[" + condition['0'] + "]";

    triggerElement = jQuery('[name="' + triggerFieldName + '"]');
    let targetElement = jQuery(sender).closest('.single-property');

    //console.log(triggerFieldName);
    triggerElement.change(
        function () {
            //console.log('Trigger value: ', triggerElement.val());
            if (condition[1] === '=') {
                if (triggerElement.val() === condition[2]) {
                    //console.log('Yes');
                    targetElement.removeClass('invisible')
                } else {
                    targetElement.addClass('invisible')
                }
            }
        }
    );
    triggerElement.trigger('change');

    //console.log(triggerElement);
}

function replaceNameToNeighbour(name, element, neighbour) {
    return name.replace("[" + element + "]", "[" + neighbour + "]")
}

function convertToSlug(Text) {
    Text = Text.replace(/^\s+|\s+$/g, ''); // trim
    Text = Text.toLowerCase();

    // remove accents, swap ñ for n, etc
    const from = "ãàáäâáº½èéëêìíïîõòóöôùúüûñç·/,:;абвгдеёжзийклмнопрстуфхцчшщьыъэюяўі";
    const to = "aaaaaa__eeeeiiiiooooouuuunc_____abvgdeezzijklmnoprstufhccss_y_euaui";
    for (let i = 0, l = from.length; i < l; i++) {
        Text = Text.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    Text = Text.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return Text;
}

function titleEdited(sender) {
    let name = sender.name;
    let newName = replaceNameToNeighbour(name, 'title', 'slug');
    let target = jQuery('[name="' + newName + '"]');
    if (!target.val()) target.val(convertToSlug(sender.value));
}

function titleKeyUp(sender) {
    let parent = jQuery(sender).closest('.single-field');
    let title = parent.find('.title');

    title.html(sender.value);
    //console.log(title);
}