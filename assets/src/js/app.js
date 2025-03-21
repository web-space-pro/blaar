try {
    require('jquery');
    // require("./vendors");
    // require("./modules/input_mask");
    require("./modules/menu");
    // require("./modules/generall");
    require("./modules/woocommerce");
    // require("./modules/custom-select");
} catch (e) {
    console.log('JS ERROR!!!', e);
}


// document.addEventListener("DOMContentLoaded", function () {
//     const spinFormId = "7556"; // ID формы CF7, связанной с колесом
//     let currentRotation = 0;
//     let spunKey = "wheelspin_spun"; // Ключ в localStorage
//
//     const prizes = [
//         { name: "2 бесплатных урока", chance: 40, angle: 0 },
//         { name: "Полное бесплатное обучение", chance: 0, angle: 60 },
//         { name: "5 уроков бесплатно", chance: 0, angle: 120 },
//         { name: "Месяц разговорных клубов", chance: 5, angle: 180 },
//         { name: "Экспресс оценка уровня", chance: 15, angle: 240 },
//         { name: "1 бесплатный урок", chance: 40, angle: 300 }
//     ];
//
//     function getRandomPrize() {
//         let random = Math.random() * 100;
//         let cumulativeChance = 0;
//         for (let i = 0; i < prizes.length; i++) {
//             cumulativeChance += prizes[i].chance;
//             if (random <= cumulativeChance) {
//                 return prizes[i];
//             }
//         }
//         return prizes[0];
//     }
//
//     function spinWheel(callback) {
//         const wheelOuter = document.querySelector(".wheelspin__outer");
//         const prizeText = document.getElementById("prizeText");
//
//         const selectedPrize = getRandomPrize(); // Определяем выигрыш заранее
//         const stopAngle = selectedPrize.angle;
//         const spins = Math.floor(Math.random() * 3) + 5;
//         const finalAngle = spins * 360 + stopAngle;
//
//         currentRotation += finalAngle;
//
//         const spinKeyframes = `
//             @keyframes spinAnimation {
//                 0% { transform: rotate(${currentRotation - finalAngle}deg); }
//                 100% { transform: rotate(${currentRotation}deg); }
//             }
//         `;
//
//         let styleTag = document.getElementById("spinAnimationStyle");
//         if (!styleTag) {
//             styleTag = document.createElement("style");
//             styleTag.id = "spinAnimationStyle";
//             document.head.appendChild(styleTag);
//         }
//         styleTag.innerHTML = spinKeyframes;
//
//         wheelOuter.style.animation = "spinAnimation 5s ease-out forwards";
//
//         wheelOuter.addEventListener("animationend", function () {
//             prizeText.textContent = selectedPrize.name;
//             document.querySelector(".present-win").classList.add("show-prize");
//
//             localStorage.setItem(spunKey, Date.now());
//
//             if (typeof callback === "function") {
//                 callback(selectedPrize); // Передаем приз в колбэк
//             }
//         }, { once: true });
//     }
//
//     function sendAdvCakeData() {
//         let proAdvData = sessionStorage.getItem("proAdvData");
//
//         if (proAdvData) {
//             proAdvData = JSON.parse(proAdvData);
//             window.advcake_data = window.advcake_data || [];
//             window.advcake_data.push({
//                 pageType: 6,
//                 user: {
//                     email: proAdvData.email,
//                     phone: proAdvData.phone,
//                     name: proAdvData.name,
//                     type: ''
//                 },
//                 leadInfo: {
//                     id: "lead_" + Math.floor(Date.now() / 1000),
//                     leadid: proAdvData.leadId,
//                     name: proAdvData.leadName,
//                     totalPrice: 0,
//                     coupon: ''
//                 }
//             });
//
//             sessionStorage.removeItem("proAdvData");
//             console.log("Данные отправлены в AdvCake.");
//         } else {
//             console.log("Нет данных в proAdvData, AdvCake не отправлен.");
//         }
//     }
//
//     function sendToBitrix(phone, prize) {
//         const contactUrl = "https://profieng.bitrix24.ru/rest/1/ho8z3mhsne8b93c1/crm.contact.add.json";
//         const dealUrl = "https://profieng.bitrix24.ru/rest/1/ho8z3mhsne8b93c1/crm.deal.add.json";
//
//         const contactData = {
//             fields: {
//                 NAME: "Клиент",
//                 PHONE: [{ VALUE: phone, VALUE_TYPE: "WORK" }],
//                 COMMENTS: `Выигрыш: ${prize}`
//             }
//         };
//
//         fetch(contactUrl, {
//             method: "POST",
//             headers: { "Content-Type": "application/json" },
//             body: JSON.stringify(contactData)
//         })
//             .then(response => response.json())
//             .then(result => {
//                 if (result.result) {
//                     const dealData = {
//                         fields: {
//                             TITLE: `Выигрыш: ${prize}`,
//                             COMMENTS: `Номер телефона: ${phone}`,
//                             STATUS_ID: "NEW",
//                             CONTACT_ID: result.result
//                         }
//                     };
//
//                     return fetch(dealUrl, {
//                         method: "POST",
//                         headers: { "Content-Type": "application/json" },
//                         body: JSON.stringify(dealData)
//                     });
//                 }
//             })
//             .then(response => response.json())
//             .then(result => console.log("Сделка добавлена в Битрикс:", result))
//             .catch(error => console.error("Ошибка при отправке данных в Битрикс:", error));
//     }
//
//     document.addEventListener("wpcf7mailsent", function (event) {
//         spinWheel(function (selectedPrize) { // Колесо всегда запускается
//             if (event.detail.contactFormId == spinFormId) { // Интеграции только если форма совпадает
//                 sendAdvCakeData();
//
//                 const phoneInput = document.querySelector('input[name="phone_number"]');
//                 if (phoneInput) {
//                     sendToBitrix(phoneInput.value, selectedPrize.name);
//                     console.log(phoneInput.value, selectedPrize.name);
//                 }
//             }
//         });
//     }, false);
// });


//new---------------------------
document.addEventListener("DOMContentLoaded", function () {
    const spinButton = document.querySelector(".spinButton");
    const prizeText = document.getElementById("prizeText");
    const wheelOuter = document.querySelector(".wheelspin__outer");
    const formContainer = document.querySelector(".formContainer");

    let currentRotation = 0;
    let spunKey = "wheelspin_spun"; // Ключ для хранения времени кручения колеса
    const spinFormId = "7556"; // ID формы CF7

    const prizes = [
        { name: "2 бесплатных урока", chance: 40, angle: 0 },
        { name: "Полное бесплатное обучение", chance: 0, angle: 60 },
        { name: "5 уроков бесплатно", chance: 0, angle: 120 },
        { name: "Месяц разговорных клубов", chance: 5, angle: 180 },
        { name: "Экспресс оценка уровня", chance: 15, angle: 240 },
        { name: "1 бесплатный урок", chance: 40, angle: 300 }
    ];

    function getRandomPrize() {
        let random = Math.random() * 100;
        let cumulativeChance = 0;

        for (let i = 0; i < prizes.length; i++) {
            cumulativeChance += prizes[i].chance;
            if (random <= cumulativeChance) {
                return prizes[i];
            }
        }
        return prizes[0];
    }

    function spinWheel() {
        wheelOuter.style.animation = "none";

        const selectedPrize = getRandomPrize();
        const stopAngle = selectedPrize.angle;
        const spins = Math.floor(Math.random() * 3) + 5;
        const finalAngle = spins * 360 + stopAngle;

        currentRotation += finalAngle;

        const spinKeyframes = `
            @keyframes spinAnimation {
                0% { transform: rotate(${currentRotation - finalAngle}deg); }
                100% { transform: rotate(${currentRotation}deg); }
            }
        `;

        let styleTag = document.getElementById("spinAnimationStyle");
        if (styleTag) {
            styleTag.innerHTML = spinKeyframes;
        } else {
            styleTag = document.createElement("style");
            styleTag.id = "spinAnimationStyle";
            styleTag.innerHTML = spinKeyframes;
            document.head.appendChild(styleTag);
        }

        wheelOuter.style.animation = "spinAnimation 5s ease-out forwards";

        // Дожидаемся завершения анимации перед выводом выигрыша
        wheelOuter.addEventListener(
            "animationend",
            function () {
                prizeText.textContent = selectedPrize.name;

                // Удаляем форму
                const formContainer = document.querySelector(".present-form");
                if (formContainer) {
                    formContainer.remove();
                }

                // Показываем выигрыш
                const winContainer = document.querySelector(".present-win");
                if (winContainer) {
                    winContainer.classList.add("show-prize");
                }

                // Фиксируем, что колесо крутилось
                localStorage.setItem(spunKey, Date.now());
            },
            { once: true }
        );
    }
    function sendToBitrix() {
        const contactUrl = "https://profieng.bitrix24.ru/rest/1/ho8z3mhsne8b93c1/crm.contact.add.json";
        const dealUrl = "https://profieng.bitrix24.ru/rest/1/ho8z3mhsne8b93c1/crm.deal.add.json";

        let proAdvData = sessionStorage.getItem("proAdvData");
        const prizeTextElement = document.getElementById("prizeText");
        let prize = prizeTextElement.textContent.trim();
        if (proAdvData) {
            proAdvData = JSON.parse(proAdvData);
        }





            const contactData = {
            fields: {
                NAME: "Клиент",
                PHONE: [{ VALUE: proAdvData.phone, VALUE_TYPE: "WORK" }],
                COMMENTS: `Выигрыш: ${prize}`
            }
        };

        fetch(contactUrl, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(contactData)
        })
            .then(response => response.json())
            .then(result => {
                if (result.result) {
                    const dealData = {
                        fields: {
                            TITLE: `Выигрыш: ${prize}`,
                            COMMENTS: `Номер телефона: ${proAdvData.phone}`,
                            STATUS_ID: "NEW",
                            CONTACT_ID: result.result
                        }
                    };

                    return fetch(dealUrl, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(dealData)
                    });
                }
            })
            .then(response => response.json())
            .then(result => console.log("Сделка добавлена в Битрикс:", result))
            .catch(error => console.error("Ошибка при отправке данных в Битрикс:", error));
    }
    function sendAdvCakeData() {
        window.advcake_data = window.advcake_data || [];

        let proAdvData = sessionStorage.getItem("proAdvData");

        if (proAdvData) {
            proAdvData = JSON.parse(proAdvData);

            window.advcake_data.push({
                pageType: 6,
                user: {
                    email: proAdvData.email,
                    phone: proAdvData.phone,
                    name: proAdvData.name,
                    type: ""
                },
                leadInfo: {
                    id: "lead_" + Math.floor(Date.now() / 1000),
                    leadid: proAdvData.leadId,
                    name: proAdvData.leadName,
                    totalPrice: 0,
                    coupon: ""
                }
            });

            sessionStorage.removeItem("proAdvData");
            console.log("Данные отправлены в AdvCake и sessionStorage очищен.");
        } else {
            console.log("Нет данных в proAdvData, отправка в AdvCake не выполнена.");
        }
    }

    // Запуск колеса и отправка данных в AdvCake после отправки формы CF7 (только для нужной формы)
    document.addEventListener(
        "wpcf7mailsent",
        function (event) {
            if (formContainer) {
                formContainer.style.display = "none";
            }
            spinWheel(); // Запуск колеса

            if (event.detail.contactFormId == spinFormId) {
                sendToBitrix(); // Отправка данных в Bitrix
                sendAdvCakeData(); // Отправка данных в AdvCake

            }
        },
        false
    );
});







//live niw

// document.addEventListener("DOMContentLoaded", function () {
//     const spinButton = document.querySelector(".spinButton");
//     const prizeText = document.getElementById("prizeText");
//     const wheelOuter = document.querySelector(".wheelspin__outer");
//     const formContainer = document.querySelector(".formContainer");
//
//     let currentRotation = 0;
//     let spunKey = "wheelspin_spun"; // Ключ для хранения времени кручения колеса
//     const spinFormId = "7820"; // ID формы CF7
//
//     const prizes = [
//         { name: "2 бесплатных урока", chance: 40, angle: 0 },
//         { name: "Полное бесплатное обучение", chance: 0, angle: 60 },
//         { name: "5 уроков бесплатно", chance: 0, angle: 120 },
//         { name: "Месяц разговорных клубов", chance: 5, angle: 180 },
//         { name: "Экспресс оценка уровня", chance: 15, angle: 240 },
//         { name: "1 бесплатный урок", chance: 40, angle: 300 }
//     ];
//
//     function getRandomPrize() {
//         let random = Math.random() * 100;
//         let cumulativeChance = 0;
//
//         for (let i = 0; i < prizes.length; i++) {
//             cumulativeChance += prizes[i].chance;
//             if (random <= cumulativeChance) {
//                 return prizes[i];
//             }
//         }
//         return prizes[0];
//     }
//
//     function spinWheel() {
//         wheelOuter.style.animation = "none";
//
//         const selectedPrize = getRandomPrize();
//         const stopAngle = selectedPrize.angle;
//         const spins = Math.floor(Math.random() * 3) + 5;
//         const finalAngle = spins * 360 + stopAngle;
//
//         currentRotation += finalAngle;
//
//         const spinKeyframes = `
//             @keyframes spinAnimation {
//                 0% { transform: rotate(${currentRotation - finalAngle}deg); }
//                 100% { transform: rotate(${currentRotation}deg); }
//             }
//         `;
//
//         let styleTag = document.getElementById("spinAnimationStyle");
//         if (styleTag) {
//             styleTag.innerHTML = spinKeyframes;
//         } else {
//             styleTag = document.createElement("style");
//             styleTag.id = "spinAnimationStyle";
//             styleTag.innerHTML = spinKeyframes;
//             document.head.appendChild(styleTag);
//         }
//
//         wheelOuter.style.animation = "spinAnimation 5s ease-out forwards";
//
//         // Дожидаемся завершения анимации перед выводом выигрыша
//         wheelOuter.addEventListener(
//             "animationend",
//             function () {
//                 prizeText.textContent = selectedPrize.name;
//
//                 // Удаляем форму
//                 const formContainer = document.querySelector(".present-form");
//                 if (formContainer) {
//                     formContainer.remove();
//                 }
//
//                 // Показываем выигрыш
//                 const winContainer = document.querySelector(".present-win");
//                 if (winContainer) {
//                     winContainer.classList.add("show-prize");
//                 }
//
//                 // Фиксируем, что колесо крутилось
//                 localStorage.setItem(spunKey, Date.now());
//             },
//             { once: true }
//         );
//     }
//
//     function sendAdvCakeData() {
//         window.advcake_data = window.advcake_data || [];
//
//         let proAdvData = sessionStorage.getItem("proAdvData");
//
//         if (proAdvData) {
//             proAdvData = JSON.parse(proAdvData);
//
//             window.advcake_data.push({
//                 pageType: 6,
//                 user: {
//                     email: proAdvData.email,
//                     phone: proAdvData.phone,
//                     name: proAdvData.name,
//                     type: ""
//                 },
//                 leadInfo: {
//                     id: "lead_" + Math.floor(Date.now() / 1000),
//                     leadid: proAdvData.leadId,
//                     name: proAdvData.leadName,
//                     totalPrice: 0,
//                     coupon: ""
//                 }
//             });
//
//             sessionStorage.removeItem("proAdvData");
//             console.log("Данные отправлены в AdvCake и sessionStorage очищен.");
//         } else {
//             console.log("Нет данных в proAdvData, отправка в AdvCake не выполнена.");
//         }
//     }
//
//     // Запуск колеса и отправка данных в AdvCake после отправки формы CF7 (только для нужной формы)
//     document.addEventListener(
//         "wpcf7mailsent",
//         function (event) {
//             if (formContainer) {
//                 formContainer.style.display = "none";
//             }
//             spinWheel(); // Запуск колеса
//
//             console.log(event.detail.contactFormId, spinFormId);
//             if (event.detail.contactFormId == spinFormId) {
//                 sendAdvCakeData(); // Отправка данных в AdvCake
//             }
//         },
//         false
//     );
// });