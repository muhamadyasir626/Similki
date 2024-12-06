        $(function () {
            "use strict";

            $("#form-tanggal-dipasangkan, #form-tanggal-dipisahkan").hide();

            $("input[name='satwa_status']").on("change", function () {
                console.log($(this).val()); 

                if ($(this).val() === "dipasangkan") {
                    $("#form-tanggal-dipasangkan").show();
                    $("#form-tanggal-dipisahkan").hide();
                } else {
                    $("#form-tanggal-dipasangkan").hide();
                    $("#form-tanggal-dipisahkan").show();
                }
            });

            $("form").on("change", function () {
                $(this)
                    .find("input, select, textarea")
                    .each(function () {
                        const isVisible = $(this).is(":visible");
                        $(this).prop("required", isVisible);
                    });
            });
        });
