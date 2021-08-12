window.onload = () => {
    let links = document.querySelectorAll("[date-delete]");

    for(link of links) {
        //on ecoute le clic
        link.addEventListener("click", function(e) {
            //empeche la navigation
            e.preventDefault();

            if(confirm("Delete this manual ?")) {
                //envoi requete AJAX vers le href du link avec la methode DELETE
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    //on recup la reponse en JSON 
                    response => response.json()
                ).then(data => {
                    if(data.succes) {
                        this.parentElement.remove();
                    }
                    else {
                        alert(data.error)
                    }
                }).catch(e => alert(e))
            }
        })
    }
}