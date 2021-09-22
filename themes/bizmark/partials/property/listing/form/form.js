// import 'jquery-validation'
import UrlGeneration from "@lovata/url-generation";

export default new(class PropertyFilter {
    constructor()
    {
        this.form = ".filter-form";
        this.radioBtn = ".radio-input";
        this.fieldInput = ".field-input";
        this.selectInput = ".select-input";
        this.checkboxBtn = ".checkbox-input";
        this.btnReset = "#btn-reset";
        this.btnSearch = "#btn-search";
        this.animalsAndKids = '.animals-and-kids';
        this.xhr = null;

        this.getData();
        this.init();
        this.initData();
        this.initSorting();
    }

    init()
    {
        const from = this.form;
        const radioBtn = this.radioBtn;
        const fieldInput = this.fieldInput;
        const selectInput = this.selectInput;
        const checkboxBtn = this.checkboxBtn;
        const btnReset = this.btnReset;

        $(this.btnSearch).on("click", (target) => {
            target.preventDefault();
            UrlGeneration.init();
            this.initData();
            this.updateCatalog();
        });

        $(selectInput).select2({
            width: "100%",
            minimumResultsForSearch: Infinity,
        });

        $(btnReset).on("click", function () {
            $(selectInput).val("Не выбрано").trigger("change");
            $(from)[0].reset();
            Validate();
            UrlGeneration.clear();

            $('#objectType').val(1).trigger('change.select2');
            let objectType = $("#objectType").val();
            UrlGeneration.set("object-type", objectType);
            UrlGeneration.update();
        });

        $(".form-input").on("change", function () {
            Validate();
        });

        $(selectInput).on("select2:select", function (e) {
            Validate();
        });

        function radioValid()
        {
            return $(radioBtn).is(":checked");
        }
        function checkboxValid()
        {
            return $(checkboxBtn).is(":checked");
        }
        function fieldValid()
        {
            return (
                $(fieldInput).filter(function () {
                    return $.trim(this.value) != "";
                }).length > 0
            );
        }
        function selectValid()
        {
            return (
                $(selectInput).filter(function () {
                    return $.trim(this.value) != "Не выбрано";
                }).length > 0
            );
        }
        function Validate()
        {
            if (radioValid() || checkboxValid() || fieldValid() || selectValid()) {
                $(btnReset).addClass("show");
            } else {
                $(btnReset).removeClass("show");
            }
        }
    }

    initSorting()
    {
        $("#sortSelect").on("change", (target) => {
            target.preventDefault();
            let sort = $("#sortSelect option").filter(":selected").val();

            UrlGeneration.set("sort", [sort]);

            this.initData();

            this.updateCatalog();
        });
    }

    getData()
    {
        let adType = this.GetURLParameter('ad-type');
        let sortType = this.GetURLParameter('sort-type');
        let numberRooms = this.GetURLParameter('numberRooms');
        let minPrice = this.GetURLParameter('min-price');
        let maxPrice = this.GetURLParameter('max-price');
        let minSquare = this.GetURLParameter('min-area');
        let maxSquare = this.GetURLParameter('max-area');
        let minFloor = this.GetURLParameter('min-floor');
        let maxFloor = this.GetURLParameter('max-price');
        let objectType = this.GetURLParameter('object-type');
        let propertyType = this.GetURLParameter('property-type');
        let repairType = this.GetURLParameter('repair-type');
        let bathType = this.GetURLParameter('bath-type');
        let furniture = this.GetURLParameter('furniture');
        let parking = this.GetURLParameter('parking');
        let pets = this.GetURLParameter('pets');
        let children = this.GetURLParameter('children');
        let elevator = this.GetURLParameter('elevator');
        let basement = this.GetURLParameter('basement');
        let penthouse = this.GetURLParameter('penthouse');

        if (adType) {
            $('.tabs .tab').removeClass('active');
            $('.tabs .tab[data-type="'+adType+'"]').addClass('active');
            if (adType == 'SALE') {
                $(this.animalsAndKids).css({ display: 'none' })
            }
            else {
                $(this.animalsAndKids).css({ display: 'block' })
            }
        }
        if (sortType) {
            $('#sortSelect').val('price|asc').trigger('change.select2');
            if (sortType === 'price%7Cdesc') {
                $('#sortSelect').val('price|desc').trigger('change.select2');
            }
        }
        if (numberRooms) {
            let arr = numberRooms.split('%7C');
            for (let i = 0; i < arr.length; i++) {
                $('input[name="numberRooms"][value='+arr[i]+']').prop('checked', true);
            }
        }
        if (minPrice) {
            $('input[name="min-price"]').val(minPrice);
        }
        if (maxPrice) {
            $('input[name="max-price"]').val(maxPrice);
        }
        if (minSquare) {
            $('input[name="min-area"]').val(minSquare);
        }
        if (maxSquare) {
            $('input[name="max-area"]').val(maxSquare);
        }
        if (minFloor) {
            $('input[name="min-floor"]').val(minFloor);
        }
        if (maxFloor) {
            $('input[name="min-floor"]').val(maxFloor);
        }
        if (objectType) {
            $('#objectType').val(objectType).trigger('change.select2');
        }
        if (propertyType) {
            $('#propertyType').val(propertyType).trigger('change.select2');
        }
        if (repairType) {
            $('#repairType').val(repairType).trigger('change.select2');
        }
        if (bathType) {
            $('#bathType').val(bathType).trigger('change.select2');
        }
        if (furniture) {
            $('input[name="furniture"]').prop('checked', true);
        }
        if (parking) {
            $('input[name="parking"]').prop('checked', true);
        }
        if (pets) {
            $('input[name="pets"]').prop('checked', true);
        }
        if (children) {
            $('input[name="children"]').prop('checked', true);
        }
        if (elevator) {
            $('input[name="elevator"]').prop('checked', true);
        }
        if (basement) {
            $('input[name="basement"]').prop('checked', true);
        }
        if (penthouse) {
            $('input[name="penthouse"]').prop('checked', true);
        }

        // this.updateCatalog();
    }

    GetURLParameter(sParam)
    {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }
    }

    initData()
    {
        UrlGeneration.clear();
        let adType;
        if ($(this.form).attr('data-adtype')) {
            adType = $(this.form).attr('data-adtype');
        } else {
            adType = $(".tabs .active").attr('data-type');
        }
        let objectType;
        if ($(this.form).attr('data-object')) {
            objectType = $(this.form).attr('data-object');
        }
        else {
            objectType = $("#objectType").val();
        }
        let numberRooms = '';
        $('input[name="numberRooms"]:checked').each(function (index) {
            numberRooms += $(this).val() + '|';
        });
        numberRooms = numberRooms.substring(0, numberRooms.length - 1);
        let minPrice = $('input[name="min-price"]').val();
        let maxPrice = $('input[name="max-price"]').val();
        let minSquare = $('input[name="min-area"]').val();
        let maxSquare = $('input[name="max-area"]').val();
        let minFloor = $('input[name="min-floor"]').val();
        let maxFloor = $('input[name="max-floor"]').val();
        let propertyType = $("#propertyType").val();
        let repairType = $("#repairType").val();
        let bathType = $("#bathType").val();
        let furniture = $('input[name="furniture"]').is(":checked");
        let parking = $('input[name="parking"]').is(":checked");
        let pets = $('input[name="pets"]').is(":checked");
        let children = $('input[name="children"]').is(":checked");
        let elevator = $('input[name="elevator"]').is(":checked");
        let basement = $('input[name="basement"]').is(":checked");
        let penthouse = $('input[name="penthouse"]').is(":checked");
        let sortType = $("#sortSelect").val();

        if (adType) {
            UrlGeneration.set('ad-type', adType);
            if (adType == 'SALE') {
                $(this.animalsAndKids).css({ display: 'none' })
            }
            else {
                $(this.animalsAndKids).css({ display: 'block' })
            }
        }
        if (objectType) {
            UrlGeneration.set("object-type", objectType);
        }
        if (propertyType) {
            UrlGeneration.set("property-type", propertyType);
        }
        if (numberRooms) {
            UrlGeneration.set("numberRooms", numberRooms);
        }
        if (minPrice) {
            UrlGeneration.set("min-price", minPrice);
        }
        if (maxPrice) {
            UrlGeneration.set("max-price", maxPrice);
        }
        if (minSquare) {
            UrlGeneration.set("min-area", minSquare);
        }
        if (maxSquare) {
            UrlGeneration.set("max-area", maxSquare);
        }
        if (minFloor) {
            UrlGeneration.set("min-floor", minFloor);
        }
        if (maxFloor) {
            UrlGeneration.set("max-floor", maxFloor);
        }
        if (repairType) {
            UrlGeneration.set("repair-type", repairType);
        }
        if (bathType) {
            UrlGeneration.set("bath-type", bathType);
        }
        if (furniture) {
            UrlGeneration.set("furniture", "true");
        }
        if (parking) {
            UrlGeneration.set("parking", "true");
        }
        if (pets) {
            UrlGeneration.set("pets", "true");
        }
        if (children) {
            UrlGeneration.set("children", "true");
        }
        if (elevator) {
            UrlGeneration.set("elevator", "true");
        }
        if (basement) {
            UrlGeneration.set("basement", "true");
        }
        if (penthouse) {
            UrlGeneration.set("penthouse", "true");
        }
        if (sortType) {
            UrlGeneration.set("sort-type", sortType);
        }

        UrlGeneration.update();
    }

    updateCatalog()
    {
        if (this.xhr) {
            this.xhr.abort();
        }

        this.xhr = $.request("OfferCatalog::onFilter", {
            success: function (response) {
                this.success(response);
            },
        });
    }
})();
