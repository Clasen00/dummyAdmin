
document.addEventListener("DOMContentLoaded", () => {
    let tabs = document.querySelectorAll(".tabs h3 a");

    Array.from(tabs).forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault();


            document.querySelector(".tabs > h3 > a.active").classList.remove('active');
            event.target.classList.add('active');

            document.querySelector(".tabs-content div.active").classList.remove('active');

            const targetPath = event.target.getAttribute('href');
            document.querySelector(".tabs-content div[id='" + targetPath.substr(1) + "']").classList.add('active');
        });
    });

    const regUserBtn = document.getElementById('regUser');
    const authUserBtn = document.getElementById('authUser');

    regUserBtn.addEventListener('click', function (event) {
        event.preventDefault();

        const regForm = document.forms.regForm;
        if (isRegFormEmpy(regForm)) {
            event.preventDefault();
            document.getElementById('regFormEmpty').classList.remove('hidden');
            return;
        } else {
            document.getElementById('regFormEmpty').classList.add('hidden');
            var formData = getRegFormToJson(regForm);
        }

        try {

            // Значения по умолчанию обозначены знаком *
            let response = fetch('/index/registerUser', {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                },
                redirect: 'follow',
                referrer: 'no-referrer',
                body: formData,
            })
                .then(response => response.json());

            console.log(response);
        } catch (error) {
            console.error('Ошибка:', error);
        }

    });

    authUserBtn.addEventListener('click', function (event) {
        event.preventDefault();

        const authForm = document.forms.authForm;

        if (isAuthFormEmpy(authForm)) {
            event.preventDefault();
            document.getElementById('authFormEmpty').classList.remove('hidden');
            return;
        } else {
            document.getElementById('authFormEmpty').classList.add('hidden');
            let formData = getAuthFormToJson(authForm);
        }

        try {
            let response = fetch('/index/authUser', {
                method: 'POST',
                body: formData
            })
                    .then(response => console.log(response));

        } catch (error) {
            console.error('Ошибка:', error);
        }

    });

    function isRegFormEmpy(formData) {
        return !formData.firstName.value
                && !formData.secondName.value
                && !formData.email.value
                && !formData.password.value;
    }

    function isAuthFormEmpy(formData) {
        return !formData.email.value
                && !formData.password.value;
    }

    function getRegFormToJson(regForm) {
        return JSON.stringify({email: regForm.email.value, firstName: regForm.firstName.value, secondName: regForm.secondName.value, password: regForm.password.value});
    }

    function getAuthFormToJson(authForm) {
        return JSON.stringify({email: authForm.email.value, password: authForm.password.value});
    }

});

