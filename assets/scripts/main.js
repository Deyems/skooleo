const replyBtn = document.querySelector(".make-comment");
const replyForm = document.querySelector(".comment-form");
const commentWrapper = document.querySelector(".comments-wrapper");
const viewComment = document.querySelector(".view-comment");

const joinBtn = document.querySelector('.join');
const usernameField = document.querySelector("input[name=username]");
const emailField = document.querySelector("input[name=email]");
const passkeyField = document.querySelector("input[name=passkey]");
const c_passkeyField = document.querySelector("input[name=passkey2]");
const registerForm = document.querySelector(".form-to-join");
const existingNode = document.querySelector(".inp-grp");
// console.log(joinBtn);
// console.log(usernameField);
//console.log(commentWrapper);
// console.log(replyBtn);
if(replyBtn){
    replyBtn.addEventListener("click", () => {
        replyForm.classList.toggle("show");
        if(replyForm.classList.contains("show")){
            replyBtn.textContent = "Hide";
        }else{
            replyBtn.textContent = "Make Comment";
        }
    });
}

if(viewComment){
    viewComment.addEventListener("click", () => {
        commentWrapper.classList.toggle("show");
        if(commentWrapper.classList.contains("show")){
            viewComment.textContent = "Hide Comments";
        }else{
            viewComment.textContent = "Show Comments";
        }
    });
}

// if(joinBtn){
//     joinBtn.addEventListener("click",(e) => {
//         if(usernameField.value === "" || emailField.value === "" || passkeyField.value === "" || c_passkeyField.value ===  ""){
//             e.preventDefault();
//             console.log("Did we get here");
//             console.log(usernameField.value,"username");
//             console.log(emailField.value,"email");
//             console.log(passkeyField.value,"password");
//             console.log(c_passkeyField.value,"confirm");

//             const errors = gatherErrors(usernameField.value, emailField.value, passkeyField.value, c_passkeyField.value);
//             //Create New Elements and add a class show-error
//             for(const error of errors){
//                 let div = document.createElement('div');
//                 div.className = "show-error";
//                 div.textContent = error;
//                 registerForm.insertBefore(div,existingNode);
//             }
//             console.log(e.target);
//         }
//     });
// }

// function gatherErrors(username,email,passkey,passkey2){
//     const errors = [];
//     let errorMsg = "";
//     if(username === ""){
//         errorMsg = "Username field cannot be empty"
//         errors.push(errorMsg);
//     }
//     if(email === ""){
//         errorMsg = "Email field cannot be empty"
//         errors.push(errorMsg);
//     }
//     if(passkey === ""){
//         errorMsg = "password field cannot be empty"
//         errors.push(errorMsg);
//     }
//     if(passkey2 === ""){
//         errorMsg = "confirm password field cannot be empty"
//         errors.push(errorMsg);
//     }
//     return errors;
// }