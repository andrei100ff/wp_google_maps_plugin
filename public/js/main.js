(function($) {

/*FORM*/

$('#contact_form').on('submit', function(e) {
    e.preventDefault();
});

$(document).ready(function() {
    $('#contact_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {
            $('#success_message').slideDown({
                opacity: "show"
            }, "slow"); // Do something ...
            $('#contact_form').data('bootstrapValidator').resetForm();

            geocoder = new google.maps.Geocoder();

            var street = $('[name="address"]').val();
            var city = $('[name="city"]').val();
            var zip = $('[name="zip"]').val();
            var state = $('[name="state"]').val();
            address = street + city + zip + state;

            geocoder.geocode({
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var loc = results[0].geometry.location;
                    var resp = form.serialize() + '&lat=' + loc.lat() + '&lng=' + loc.lng();
                    console.log(resp);
                    var bv = form.data('bootstrapValidator');
                    // Use Ajax to submit form data
                    $.post(child_script_vars.path+'includes/mailerfull.php', resp, function(result) {
                        console.log(result);
                    }, 'json');

                } else {
                    console.log('Geocode was not successful for the following reason: ' + status);
                    alert('Google cannot locate your coordinates based on your information. Please provide more accurate address that would have a definite result on Google maps');
                }
            });

        },
        fields: {
            first_name: {
                validators: {
                    stringLength: {
                        min: 2,
                    },
                    notEmpty: {
                        message: 'Please supply your first name'
                    }
                }
            },
            last_name: {
                validators: {
                    stringLength: {
                        min: 2,
                    },
                    notEmpty: {
                        message: 'Please supply your last name'
                    }
                }
            },
            company: {
                validators: {
                    stringLength: {
                        min: 2,
                    },
                    notEmpty: {
                        message: 'Please supply your company name'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your phone number'
                    },
                    phone: {
                        country: 'US',
                        message: 'Please supply a vaild phone number with area code'
                    }
                }
            },
            address: {
                validators: {
                    stringLength: {
                        min: 8,
                    },
                    notEmpty: {
                        message: 'Please supply your street address'
                    }
                }
            },
            city: {
                validators: {
                    stringLength: {
                        min: 4,
                    },
                    notEmpty: {
                        message: 'Please supply your city'
                    }
                }
            },
            state: {
                validators: {
                    notEmpty: {
                        message: 'Please select your state'
                    }
                }
            },
            zip: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your zip code'
                    },
                    zipCode: {
                        country: 'US',
                        message: 'Please supply a vaild zip code'
                    }
                }
            }
        }
    });
});

function locatemarker() {

    geocoder = new google.maps.Geocoder();

    var street = $('[name="address"]').val();
    var city = $('[name="city"]').val();
    var zip = $('[name="zip"]').val();
    var state = $('[name="state"]').val();
    address = street + city + zip + state;

    geocoder.geocode({
        'address': address
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {

            //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
            /*            console.log(results[0].geometry.location);
                        console.log(JSON.stringify(results[0].geometry.location));
            */
            var loc = results[0].geometry.location;
            console.log(loc);
            return results[0].geometry.location;

            /*            $.post('latlngtodb.php', JSON.stringify(loc) , function(result) {
                            console.log(result);
                        }, 'json');
            */
            /*            map.setCenter( results[0].geometry.location );
                        var marker = new google.maps.Marker( {
                            map     : map,
                            position: results[0].geometry.location
                        } );*/
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
            alert('Google cannot locate your coordinates based on your information. Please provide more accurate address that would have a definite result on Google maps');
        }
    });

}


})( jQuery );