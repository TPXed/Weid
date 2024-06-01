document.addEventListener("DOMContentLoaded", async function () {
    const accountCreationDate = document.getElementById("account-creationdate");
    const userEmail = document.getElementById("user-email");
    const userInfo = document.getElementById("user-info");

    async function loadProfileInfo() {
    try {
    const response = await fetch('getProfileInfo.php', {
    method: 'POST',
    });
    const data = await response.text();

    const [email, created, info] = data.split('|');

    userEmail.value = email;
    userInfo.value = info;
    userEmail.innerText = email;
accountCreationDate.innerText = created;
userInfo.innerText = info;
} catch (error) {
console.error(error.message);
}
}

loadProfileInfo();
});
