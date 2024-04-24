function splitList(originalList, indexes) {
    let result = [];
    let start = 0;

    for (let index of indexes) {
        result.push(originalList.slice(start, index));
        start = index;
    }

    result.push(originalList.slice(start));

    result.shift()

    return result;
}

console.log(userData);

function addEssayElement(userData) {
    n = 1;
    for (let i = 0; i < userData.length; i++) {
        let titleSpan = document.createElement('span');
        titleSpan.innerHTML = userData[i].Essay_Title + " ";
        titleSpan.style.fontWeight = 'bold';
        let dateSpan = document.createElement('span');
        dateSpan.innerHTML = userData[i].Essay;


        class_ = "columb-"
        let result = class_.concat(n.toString())

        columb = document.getElementsByClassName(result);

        console.log(columb[0])

        let Card_div = document.createElement('div');
        Card_div.classList.add("Card");
        Card_div.setAttribute('Essay-Id', userData[i].Essay_Id);

        let Title_div = document.createElement('div');
        Title_div.classList.add("Title");
        Title_div.innerHTML = userData[i].Essay_Title;

        Card_div.appendChild(Title_div)

        if (userData[i].Essay !== null){
            let Essay_div = document.createElement('div');
            Essay_div.classList.add("Essay");
            Essay_div.id= ""+userData[i].Essay_Id;

            Essay = userData[i].Essay.split("/divider/")

            const resultIndexes = [];
 
            substring = "/ID/"

            Essay.forEach((str, index) => {
                if (str.includes(substring)) {
                resultIndexes.push(index);
                }
            });

            Essay = splitList(Essay, resultIndexes)

            console.log(Essay)

            result = ''

            Essay.forEach((array) => {
                console.log(array)
                result += array[1]+"<br>"
                for (j = 2; j < array.length; j++){
                    result += array[j]
                }
                result += "<br>"
            })
            console.log(result)

            P = document.createElement("p")
            P.innerHTML = result.substring(0, 300);
            

            Essay_div.appendChild(P)
            Card_div.appendChild(Essay_div)
        }
        

        
        


        // Card_div.addEventListener('click', function() {
        //     // Retrieve the essay ID from the data attribute
        //     let essayId = this.getAttribute('data-essay-id');
        //     // Call a function to send the ID to a PHP script
        //     sendEssayIdToPHP(essayId);
        // });

        Card_div.addEventListener('click', function () {
            // console.log("Clicked card with Essay_Id:", userData[i].Essay_Id);
            // document.cookie = "selected_essay="+userData[i].Essay_Id;
            window.location.href = "https://solariass.infinityfreeapp.com/ERRS?selected_essay="+userData[i].Essay_Id;
        });

        

        columb[0].appendChild(Card_div)

        n = (n % 3) + 1;
        console.log(n);
        
    }
}


addEssayElement(userData)