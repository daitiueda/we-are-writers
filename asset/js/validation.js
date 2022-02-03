window.addEventListener('DOMContentLoaded',() => {

  const submit = document.querySelector('.submit');

    submit.addEventListener('click', (e) => {

      const name = document.querySelector('#name');

        const errMsgName = document.querySelector('.err-msg-name');

        if(!name.value.trim()){
          errMsgName.textContent = '氏名が入力されていません';
          e.preventDefault();
        }else if(!name.value.match(/^.{1,10}$/)){
            errMsgName.textContent = '10文字以内で入力してください';
            e.preventDefault();
        }else{
            errMsgName.textContent = '';
        }

        const kana = document.querySelector('#kana');
        const errMsgKana = document.querySelector('.err-msg-kana');
        if(!kana.value.trim()){
            errMsgKana.textContent = 'フリガナが入力されていません';
            e.preventDefault();
        }else if(kana.value.match(/^[ア-ン゛゜ァ-ォャ-ョー「」、]{1,10}$/) || kana.value.match(/^[ｦ-ﾟ]{1,10}$/)){
            errMsgKana.textContent = '';
        }else{
            errMsgKana.textContent = 'カタカナ10字以内で入力してください';
            e.preventDefault();
        }

        const tel = document.querySelector('#tel');
        const errMsgTel = document.querySelector('.err-msg-tel');
        if(!tel.value.trim()){
            errMsgTel.textContent = '';
        }else if(!tel.value.match(/[0-9]/)){
            errMsgTel.textContent = '正しく入力してください';
            e.preventDefault();
        }else{
            errMsgTel.textContent = '';
        }

        const email = document.querySelector('#email');
        const errMsgEmail = document.querySelector('.err-msg-email');

        if(!email.value.trim()){
            errMsgEmail.textContent = 'メールアドレスが入力されていません';
            e.preventDefault();
        }else if(!email.value.match(/^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/)){
            errMsgEmail.textContent = 'メールアドレスが正しく入力してください';
            e.preventDefault();
        }else{
            errMsgEmail.textContent = '';
        }

        const body = document.querySelector('#body');
        const errMsgBody = document.querySelector('.err-msg-body');
        if(!body.value.trim()){
            errMsgBody.textContent = 'お問い合わせ内容が入力されていません';
            e.preventDefault();
        }else{
            errMsgBody.textContent = '';
        }

    },false);
},false);
