document.addEventListener("DOMContentLoaded", async function () {
    const updatePictureButton = document.getElementById("update-picture");
    const deletePictureButton = document.getElementById("delete-picture");
    const fileInput = document.getElementById("file-input");
    const profilePicture = document.getElementById("profile-picture");
    async function deleteProfilePicture() {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "upload-profile-picture.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    resolve(xhr.responseText);
                }
            };
            xhr.send("action=delete");
        });
    }
    updatePictureButton.addEventListener("click", function () {
        fileInput.click();
    });
    fileInput.addEventListener("change", async function () {
        const formData = new FormData();
        formData.append("action", "update");
        formData.append("image", fileInput.files[0]);
        try {
            const response = await uploadProfilePicture(formData);
            if (response.startsWith("success")) {
                profilePicture.src = response.split("|")[1];
            }
            location.reload();
        } catch (error) {
            console.error(error.message);
        }
    });
  
    deletePictureButton.addEventListener("click", async function () {
        try {
          
            const response = await deleteProfilePicture();
            if (response.startsWith("success")) {
                profilePicture.src = "avatars/placeholder.png";
                const updatedProfilePicturePath = await getProfilePicture();
                if (updatedProfilePicturePath !== "null") {
                    profilePicture.src = updatedProfilePicturePath;
                } else {
                    profilePicture.src = "avatars/placeholder.png";
                }
            }
            location.reload();
        } catch (error) {
            console.error(error.message);
        }
    });
    
    async function getProfilePicture() {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "upload-profile-picture.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    resolve(xhr.responseText);
                }
            };
            xhr.send("action=getProfilePicture");
        });
    }
 
    async function uploadProfilePicture(formData) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "upload-profile-picture.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    resolve(xhr.responseText);
                } else {
                    reject(new Error("Ошибка загрузки изображения"));
                }
            };
            xhr.send(formData);
        });
    }
   
    const profilePicturePath = await getProfilePicture();
    if (profilePicturePath !== "null") {
        profilePicture.src = profilePicturePath;
    } else {
        profilePicture.src = "avatars/placeholder.png";
    }
});
