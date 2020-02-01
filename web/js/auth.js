
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
            
            //hidden any notice when form changing
            hideWarnings();
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

        makeRequest('/index/register', formData, 'regFormNotFull');
        
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
            var formData = getAuthFormData(authForm);
        }

        makeRequest('/index/auth', formData, 'authFormNotFull');

    });
    
    function makeRequest (url, formData, placeholderIfNotFull) {
        let response = fetch(url, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
            },
            body: formData,
        })
        .then((response) => {
          response.json()
            .then((json) => {
                processRequest(json, placeholderIfNotFull);
            })
        });
    }

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
    
    function getAuthFormData(authForm) {
        var formData = new FormData();
        formData.append('email', authForm.email.value);
        formData.append('password', authForm.password.value);
        formData.append('remember', authForm.remember.value);

        return formData;
    }
    
    function processRequest(json, placeHolderId) {
        const responseMessage = json[0].message;
        const responseIsValidated = json[0].isValidated;
        
        if (responseIsValidated) {
            window.location.href = "http://dummyadmin/index";
        } else {
            noticeUser(responseMessage, placeHolderId);
        }
    }

    function noticeUser(message, placeHolderId) {
        var formNotFull = document.getElementById(placeHolderId);
        formNotFull.innerHTML = message;
        formNotFull.classList.remove('hidden');
    }
    
    function hideWarnings() {
        let warnings = document.getElementsByClassName('form-warning');
        
        Array.from(warnings).forEach(warning => {
            if (!warning.classList.contains('hidden')) {
                warning.classList.add('hidden');
            }
        });
    }
    
    function showPassword () {
        const showPassBtns = document.querySelectorAll('[data-show]');
        
        Array.from(showPassBtns).forEach(showPassBtn => {
            showPassBtn.addEventListener('click', (event) => {
                
                let passwordInput = event.target.nextElementSibling;
                if (!passwordInput.classList.contains('password')) return;

                if (passwordInput.getAttribute('type') === 'password') {
                    passwordInput.setAttribute('type', 'text');
                } else {
                    passwordInput.setAttribute('type', 'password');
                }
            });
        });
    };
    
    showPassword();
});

