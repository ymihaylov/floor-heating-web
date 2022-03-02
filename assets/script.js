$(document).ready(function(){
    // === Plus minus buttons
    $('.qty .count').prop('disabled', true);

    $(document).on('click','.control.plus',function() {
        var roomId = $(this).parents('tr').attr('id');
        var $countInput = $('#'+roomId).find('.qty .count');

        if ($countInput.val() >= 30) {
            return;
        }

        $countInput.val(parseFloat($countInput.val()) + 0.5);
        sendSetFloorTempRequest();
    });

    $(document).on('click', '.control.minus',function() {
        var roomId = $(this).parents('tr').attr('id');
        var $countInput = $('#'+roomId).find('.qty .count');

        if ($countInput.val() <= 16) {
            return;
        }

        $countInput.val(parseFloat($countInput.val()) - 0.5);
        sendSetFloorTempRequest();
    });

    // === Send set floor temp request
    function sendSetFloorTempRequest(roomId, newTemp) {
        var data = {};

        $('.qty .count').each(function(index) {
            var roomId = $(this).parents('tr').attr('id')
            data[roomId] = $(this).val() * 1000;
        });

        $.ajax({
            dataType: "json",
            data: data,
            url: 'setFloorTemp.php',
            method: 'POST',
            success: function(response) {
                console.log(response);
            }
        });
    }

    // === Get Floor Info
    function getFloorInfo() {
        $.ajax({
            dataType: "json",
            url: 'getFloorTempInfo.php',
            success: function(floorTempRows) {
                for (var key in floorTempRows) {
                    var currentRow = $('table').find('#'+floorTempRows[key]['id']);

                    currentRow.find('.current-floor-temp').text(floorTempRows[key]['current_floor_temp']);
                    currentRow.find('.floor-temp-set').val(floorTempRows[key]['floor_temp_set']);

                    var $isOpenContainer = currentRow.find('.is-open');
                    $isOpenContainer.removeClass('bg-success');
                    $isOpenContainer.removeClass('bg-danger');

                    if (floorTempRows[key]['is_open']) {
                        $isOpenContainer.addClass('bg-success');
                        $isOpenContainer.text('Open');
                    } else {
                        $isOpenContainer.addClass('bg-danger');
                        $isOpenContainer.text('Close');
                    }
                }



                // "H:i, Y-m-d"
                setLastUpdatedNow();
            }
        });
    }

    function setLastUpdatedNow() {
        var now = new Date(),
            time = {
                hours: now.getHours(),
                minutes: now.getMinutes(),
                seconds: now.getSeconds()
            };

        for (const key in time) {
            if (time[key] < 10) {
                time[key] = '0' + time[key];
            }
        }

        $('#last-updated').text(time.hours + ':' + time.minutes + ':' + time.seconds);
    }

    getFloorInfo();

    setInterval(getFloorInfo, 5000);
});
