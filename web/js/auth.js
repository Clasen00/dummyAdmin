
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
            var formData = getRegFormData(regForm);
        }

        let response = fetch('/index/register', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
            },
            body: formData,
        })
        .then((response) => {
          response.json()
            .then((json) => {
              const responseMessage = json[0].message
              const responseIsValidated = json[0].isValidated
              if (responseIsValidated) {
                  window.location.href = "http://dummyadmin/index";
              } else {
                  noticeUser(responseMessage);
              }
            })
        });
        
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

    function getRegFormData(regForm) {
        var formData = new FormData();
        formData.append('email', regForm.email.value);
        formData.append('firstName', regForm.firstName.value);
        formData.append('secondName', regForm.secondName.value);
        formData.append('password', regForm.password.value);

        return formData;
    }

    function getAuthFormToJson(authForm) {
        return JSON.stringify({email: authForm.email.value, password: authForm.password.value});
    }

    function noticeUser(message) {
        var regFormNotFull = document.getElementById('regFormNotFull');
        regFormNotFull.innerHTML = message;
        regFormNotFull.classList.remove('hidden');
    }
});

