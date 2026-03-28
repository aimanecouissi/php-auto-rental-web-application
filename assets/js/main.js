// ANIMATE ON SCROLL

AOS.init();
AOS.init({
    offset: 120,
    delay: 0,
    duration: 400,
    easing: 'ease',
    once: true,
    anchorPlacement: 'top-bottom',
});

// OWL CAROUSEL

$('.owl-carousel').owlCarousel({
    loop: true,
    margin: 30,
    nav: false,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        1000: {
            items: 3
        }
    }
})

// TODAY AND TOMORROW

function inputDateFormat(date) {
    var dd = date.getDate();
    var mm = date.getMonth() + 1;
    var yyyy = date.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    return yyyy + '-' + mm + '-' + dd;
}

function tomorrow_after() {
    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1)
    document.getElementById('start_date').setAttribute('min', inputDateFormat(tomorrow));
    document.getElementById('start_date').setAttribute('max', inputDateFormat(tomorrow));
    document.getElementById('start_date').setAttribute('value', inputDateFormat(tomorrow));
    var after = new Date();
    after.setDate(after.getDate() + 2)
    document.getElementById('end_date').setAttribute('min', inputDateFormat(after));
    document.getElementById('end_date').setAttribute('value', inputDateFormat(after));
}

// TOTAL PRICE

function calculate_price() {
    var start_date = document.getElementById('start_date');
    var end_date = document.getElementById('end_date');
    var duration = document.getElementById('duration');
    var price = document.getElementById('price');
    var total_price = document.getElementById('total_price');
    var tomorrow = new Date();
    var after = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1)
    after.setDate(after.getDate() + 2)
    var date1 = new Date(start_date.value);
    var date2 = new Date(end_date.value);
    var date3 = new Date(end_date.value);
    if (date1.getTime() >= date2.getTime()) {
        start_date.value = inputDateFormat(tomorrow);
        end_date.value = inputDateFormat(after);
        date1 = new Date(start_date.value);
        date2 = new Date(end_date.value);
        date3 = new Date(end_date.value);
        tomorrow_after();
    }
    var newTomorrow = new Date(date3.setDate(date3.getDate() - 1));
    start_date.setAttribute('max', inputDateFormat(newTomorrow));
    const diffTime = Math.abs(date2 - date1);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    duration.innerHTML = diffDays;
    total_price.innerHTML = parseFloat(price.innerHTML) * diffDays;
}

// LOADER AND SUBMIT

function check_card(event) {
    if (document.getElementById('number').value.length < 16 || document.getElementById('number').value.length > 16) {
        alert('Please, enter a valid credit card number.');
        event.preventDefault();
        return false;
    }
    if (document.getElementById('mm').value < 1 || document.getElementById('mm').value > 12 || document.getElementById('mm').value.length != 2) {
        alert('Please, enter a valid expiration month for your credit card.');
        event.preventDefault();
        return false;
    }
    if (document.getElementById('yy').value < new Date().getFullYear().toString().slice(-2) || document.getElementById('yy').value.length != 2) {
        alert('Please, enter a valid expriration year for your credit card.');
        event.preventDefault();
        return false;
    }
    if (document.getElementById('cvv').value.length != 3) {
        alert('Please, enter a valid cvv for your credit card.');
        event.preventDefault();
        return false;
    }
    return true;
}

function load_submit(event) {
    var inputs = document.querySelectorAll('.form-control');
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value.trim() == '') {
            alert('Please, add your credit card informations first.');
            return false;
        }
    }
    document.getElementsByClassName('loader')[0].classList.remove('d-none');
    event.preventDefault();
    setTimeout(function () {
        document.getElementsByClassName('loader')[0].classList.add('d-none');
        if (check_card(event)) event.target.submit();
    }, 3000);
}

// DELETE CAR CONFIRMATION

var clicked;

function delete_car(event) {
    if (clicked == 'delete') {
        if (confirm('Do you really want to delete this car?') == false) {
            event.preventDefault();
            return false;
        }
    }
}

// UPLOAD IMAGE

if (document.getElementById('photo_upload')) {
    document.getElementById('photo_upload').addEventListener('change', function () {
        var reader = new FileReader();
        reader.readAsDataURL(document.getElementById('photo_upload').files[0]);
        reader.onload = function () {
            document.getElementById('photo_show').setAttribute('src', reader.result);
        }
        if (document.querySelector('.car-img')) {
            document.querySelector('.car-img').classList.remove('border-dashed');
        }
    })
}


// PASSWORD STRENGTH
if (document.getElementById('password_strength1') && document.getElementById('password_strength2')) {
    document.getElementById('password_strength1').style.display = 'none';
    document.getElementById('password_strength2').style.display = 'none';
}

function check_strength(input) {
    let regExpWeak = /[A-Za-z]/;
    var regExpMedium = /\d+/;
    var regExpStrong = /.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/;
    var no = 0;
    if (input == document.getElementById('password1') || input == document.getElementById('password')) {
        var passwordStrength = document.querySelector('#password_strength1');
        var weak = document.querySelector('#password_strength1 .weak');
        var medium = document.querySelector('#password_strength1 .medium');
        var strong = document.querySelector('#password_strength1 .strong');
    }
    if (input == document.getElementById('password2')) {
        var passwordStrength = document.querySelector('#password_strength2');
        var weak = document.querySelector('#password_strength2 .weak');
        var medium = document.querySelector('#password_strength2 .medium');
        var strong = document.querySelector('#password_strength2 .strong');
    }
    if (input.value == '')
        passwordStrength.style.display = 'none';
    else {
        passwordStrength.style.display = 'block';
        if (input.value.length <= 4 && (input.value.match(regExpWeak) || input.value.match(regExpMedium) || input.value.match(regExpStrong))) no = 1;
        if (input.value.length >= 4 && ((input.value.match(regExpWeak) && input.value.match(regExpMedium)) || (input.value.match(regExpMedium) && input.value.match(regExpStrong)) || (input.value.match(regExpWeak) && input.value.match(regExpStrong)))) no = 2;
        if (input.value.length >= 8 && input.value.match(regExpWeak) && input.value.match(regExpMedium) && input.value.match(regExpStrong)) no = 3;
        if (no == 1)
            weak.classList.add('weak-active');
        if (no == 2) {
            weak.classList.add('weak-active');
            medium.classList.add('medium-active');
        }
        else
            medium.classList.remove('medium-active');
        if (no == 3) {
            weak.classList.add('weak-active');
            medium.classList.add('medium-active');
            strong.classList.add('strong-active');
        }
        else
            strong.classList.remove('strong-active');
    }
}

// TOOLTIP

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))