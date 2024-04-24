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

function DisplaySelectedEssay(essayData) {
    Essay = essayData.Essay.split('/divider/')
    Essay.pop()
    title = document.getElementById("Essay_Title");
    title.value = essayData.Essay_Title;

    console.log(Essay)

    const resultIndexes = [];
 
    substring = "/ID/"

    Essay.forEach((str, index) => {
        if (str.includes(substring)) {
          resultIndexes.push(index);
        }
    });

    Essay = splitList(Essay, resultIndexes)

    console.log(Essay)


    // Essay.forEach((array) => {
    //     var div = document.createElement("div")
    //     div.setAttribute('id', array[0]);
    //     div.style.boxShadow = "rgb(" + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 255) + ") -6px 4px 0px -4px";

    //     var articleElement = document.createElement("div")
    //     articleElement.setAttribute('id', array[1]);
    //     articleElement.classList.add("Outline_title_essay")
    //     articleElement.contentEditable = true;

    //     div.appendChild(articleElement);

    //     for (var i = 2; i < array.length; i++) {
    //         console.log("hi")
    //         if (array[i] == "br>"){
    //             let br = document.createElement('br');
    //             articleElement.appendChild(br);
    //         }
    //         else{
    //             var para = document.createElement("p");
    //             para.innerHTML = array[i]
    //             articleElement.appendChild(para);
    //         }
            
    //     }

    //     console.log(div)

    //     text = document.getElementById("outline_holder");
    //     text.appendChild(div)
    // })

    Essay.forEach((array) => {
        id = array[0].replace("/ID/", "")

        var box_id = "Outline_Main_" + id;
        var text_id = "Outline_Title_" + id;
        var input_id = "Input_" + id;
        var side_id = "Box_" + id;

        AddOutlineToEssay(array, box_id, text_id, input_id)
        AddOutlineToSideView(array, side_id, input_id, text_id, box_id)
    })



}

function DeleteOutline(side_id, page_id){
    side_element = document.getElementById(side_id);
    page_element = document.getElementById(page_id);
    side_element.remove()
    page_element.remove()
}

function AddOutlineToSideView(array, side_id, input_id, text_id, box_id){
    // Create main container div
    var boxDiv = document.createElement("div");
    
    boxDiv.setAttribute('id',side_id);
    boxDiv.classList.add("Box");

    // Create outline title div
    var outlineTitleDiv = document.createElement("div");
    outlineTitleDiv.classList.add("Outline_title");

    // Create article element
    // var articleElement = document.createElement("article");
    // articleElement.classList.add("ant-typography");
    // articleElement.setAttribute("value", "Untitled outline topic");
    // articleElement.textContent = "Untitled outline topic";
    var input = document.createElement("input");
    input.setAttribute('id',input_id);
    input.setAttribute("value", array[1]);
    input.oninput = function() {updateContent(input_id, text_id)};
    input.classList.add("Outline_Title");

    // Create Outline Buttons div
    var outlineButtonsDiv = document.createElement("div");
    outlineButtonsDiv.classList.add("Outline_Buttons");

    // Create Edit button
    var editButton = document.createElement("button");
    editButton.setAttribute("type", "button");
    editButton.classList.add("btn_outline_edit");
    editButton.onclick = function() {DeleteOutline(side_id, box_id)};

    var editIconSpan = document.createElement("span");
    editIconSpan.setAttribute("role", "img");
    editIconSpan.setAttribute("aria-label", "edit");
    editIconSpan.setAttribute("tabindex", "-1");
    editIconSpan.classList.add("anticon", "anticon-edit");

    var editIconSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    // editIconSvg.setAttribute("viewBox", "64 64 896 896");
    editIconSvg.setAttribute("viewBox", "0 0 448 512");
    editIconSvg.setAttribute("focusable", "false");
    editIconSvg.setAttribute("data-icon", "edit");
    editIconSvg.setAttribute("width", "1em");
    editIconSvg.setAttribute("height", "1em");
    editIconSvg.setAttribute("fill", "currentColor");
    editIconSvg.setAttribute("aria-hidden", "true");

    var editIconPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
    // editIconPath.setAttribute("d", "M257.7 752c2 0 4-.2 6-.5L431.9 722c2-.4 3.9-1.3 5.3-2.8l423.9-423.9a9.96 9.96 0 000-14.1L694.9 114.9c-1.9-1.9-4.4-2.9-7.1-2.9s-5.2 1-7.1 2.9L256.8 538.8c-1.5 1.5-2.4 3.3-2.8 5.3l-29.5 168.2a33.5 33.5 0 009.4 29.8c6.6 6.4 14.9 9.9 23.8 9.9zm67.4-174.4L687.8 215l73.3 73.3-362.7 362.6-88.9 15.7 15.6-89zM880 836H144c-17.7 0-32 14.3-32 32v36c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-36c0-17.7-14.3-32-32-32z");
    editIconPath.setAttribute("d", "M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z")

    // Append elements together
    editIconSvg.appendChild(editIconPath);
    editIconSpan.appendChild(editIconSvg);
    editButton.appendChild(editIconSpan);

    // Create More button
    var moreButton = document.createElement("button");
    moreButton.setAttribute("type", "button");
    moreButton.classList.add("btn_outline_more");

    var moreIconSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    moreIconSvg.setAttribute("stroke", "currentColor");
    moreIconSvg.setAttribute("fill", "currentColor");
    moreIconSvg.setAttribute("stroke-width", "0");
    moreIconSvg.setAttribute("viewBox", "0 0 24 24");
    moreIconSvg.setAttribute("class", "css-f7d20k");
    moreIconSvg.setAttribute("height", "1em");
    moreIconSvg.setAttribute("width", "1em");

    var moreIconPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
    moreIconPath.setAttribute("d", "M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z");

    // Append elements together
    moreIconSvg.appendChild(moreIconPath);
    moreButton.appendChild(moreIconSvg);

    // Append buttons to Outline Buttons div
    outlineButtonsDiv.appendChild(editButton);
    outlineButtonsDiv.appendChild(moreButton);

    // Append elements to their parent containers
    outlineTitleDiv.appendChild(input);
    outlineTitleDiv.appendChild(outlineButtonsDiv);

    boxDiv.appendChild(outlineTitleDiv);

    // Append the main container to the body or any other container you desire
    var div = document.getElementById("Outline");
    div.appendChild(boxDiv);
}





function AddOutlineToEssay(array, box_id, text_id, input_id){
    var div = document.createElement("div")
    div.setAttribute('id', box_id);
    div.style.boxShadow = "rgb(" + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 255) + ") -6px 4px 0px -4px";

    var articleElement = document.createElement("div");
    articleElement.setAttribute('id', text_id);
    articleElement.classList.add("Outline_title_essay");
    articleElement.contentEditable = true;

    articleElement.oninput = function() {updateContent(text_id, input_id)};

    div.appendChild(articleElement);

    for (var i = 1; i < array.length; i++) {
        console.log("hi")
        if (array[i] == "br>"){
            let br = document.createElement('br');
            articleElement.appendChild(br);
        }
        else{
            var para = document.createElement("p");
            para.innerHTML = array[i]
            articleElement.appendChild(para);
        }
        
    }

    document.getElementsByClassName("outline_holder")[0].appendChild(div)
}

function ReplaceAndOrganize(list, rewrite){
    list[1] = rewrite;
    var buffer = ""
    for (var i = 1; i < list.length; i++) {
        list[i-1] = list[i].replaceAll("<p>", "");
        list[i-1] = list[i-1].replaceAll("</p>", "");
        buffer += '<p>'+list[i-1]+'</p>';
    }
    return buffer;

}

function updateContent(sourceId, targetId){
    var sourceElement = document.getElementById(sourceId);
    var targetElement = document.getElementById(targetId);

    // console.log(sourceElement, targetElement)

    if (sourceElement.tagName.toLowerCase() === 'input') {

        buffer = targetElement.innerHTML.split("<p>");
        buffer = ReplaceAndOrganize(buffer, sourceElement.value);

        targetElement.innerHTML=buffer;
    }
    else{
        value = sourceElement.innerHTML.split('<p>');
        value = value[1].replaceAll('</p>', '')
        targetElement.value = value 
    }
    // if (targetElement.tagName.toLowerCase() === 'input')
}

function CreateOutline() {
    var id_part = Math.random().toString(16).slice(2);

    var side_id = "Box_" + id_part;
    var box_id = "Outline_Main_" + id_part;
    var input_id = "Input_" + id_part;
    var text_id = "Outline_Title_" + id_part;

    array = ['', 'Untitled Outline']

    AddOutlineToSideView(array, side_id, input_id, text_id, box_id)
    AddOutlineToEssay(array, box_id, text_id, input_id)

    // var text_div = document.getElementById(text_id)
    // console.log(text_div)
    // text_div.oninput = function() {handleEdit()};

    document.getElementById(input_id).focus();
}

DisplaySelectedEssay(essayData)
// Synonyms_btn = document.getElementById('Synonyms_btn')
// Synonyms_btn.onkeypress = function() {Synonym_redirect(event)}



function ReadySave(){
    var htmlContent = document.getElementById("outline_holder").innerHTML;

    start = '<div class="outline_topic_block" id="outline_topic_block" name="outline_holder" data-placeholder="" data-editor-blockid="gpLqx0Uc2L" style="box-shadow: none;"></div>'
    htmlContent = htmlContent.replace(start, "")

    // htmlContent = htmlContent.replace('\n                                    \n', "")

    

    htmlContent = htmlContent.replaceAll('p>', '')  

    htmlContent = htmlContent.split('<')
    htmlContent.shift()

    buffer = [];
    let substring = "/";
    let substring1 = "Outline_Title"
    for (var i = 0; i < htmlContent.length; i++){
        if (!htmlContent[i].includes(substring) && !htmlContent[i].includes(substring1) && htmlContent[i] != ""){
            buffer.push(htmlContent[i]);
        }
    }
    htmlContent = buffer


    const resultIndexes = [];
 
    substring = "Outline_Main"

    htmlContent.forEach((str, index) => {
        if (str.includes(substring)) {
          resultIndexes.push(index);
        }
      });

    console.log(htmlContent);

    resultIndexes.forEach((index, i) => {   
        match = htmlContent[index].match(/id="Outline_Main_([^"]+)"/);
        htmlContent[index] = "/ID/"+match[1]

    })  


    
    console.log(htmlContent);

    let result = ''
    for (let i = 0; i < htmlContent.length; i++) {
        // Append the current element to the result string
        result += htmlContent[i]+"/divider/";
    }

    htmlContent = result

    console.log(htmlContent);

    // Add essay nad title to input fields

    document.getElementById("essay").value = htmlContent;
    document.getElementById("essay_Title").value = document.getElementById("Essay_Title").value;

        

    document.getElementById("essay_submit").submit();
}

function Outline(){
    const Outline = document.getElementById('Outline');
    if (Outline) {
      Outline.classList.remove('hidden');
      const children = Outline.querySelectorAll('*');
      children.forEach(child => {
        child.classList.remove('hidden');
      });
    }

    const Produce = document.getElementById('Produce');
    if (Produce) {
      Produce.classList.add('hidden');
      const children = Produce.querySelectorAll('*');
      children.forEach(child => {
        child.classList.add('hidden');
      });
    }
}

function Produce(){
    const Produce = document.getElementById('Produce');
    if (Produce) {
      Produce.classList.remove('hidden');
      const children = Produce.querySelectorAll('*');
      children.forEach(child => {
        child.classList.remove('hidden');
      });
    }

    const Outline = document.getElementById('Outline');
    if (Outline) {
      Outline.classList.add('hidden');
      const children = Outline.querySelectorAll('*');
      children.forEach(child => {
        child.classList.add('hidden');
      });
    }
}







async function fetchData(search){
    if (search){
        Search = search
    }else{
        Search = document.getElementById("Synonyms_btn").value
    }

    const options = {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': data[0],
            'X-RapidAPI-Host': data[1]
        }
    };

    const url = 'https://synonyms-word-info.p.rapidapi.com/v1/word/synonyms?str='+Search;
    try {
        const response = await fetch(url, options);
        // result = await JSON.parse(response);
        // console.log(result);
        const result = await response.text();
        const parsedData = JSON.parse(result);

        const array = [];

        for (const synonym of parsedData['data']['synonyms']) {
            array.push(synonym[0]); // Append the first element of each synonym array
        }

        console.log(array);

        const list = document.getElementById("Synonyms")
        list.innerHTML = ""

        for (let i = 1; i <= 8; i++) {
            const li = document.createElement("li");
            li.textContent = array[i-1];
            list.appendChild(li);
        }


    } catch (error) {
        console.error(error);
    }

}


var editableDiv = document.getElementById("outline_holder");

editableDiv.addEventListener("dblclick", handleDoubleClick);

function handleDoubleClick(event) {
    var selection = window.getSelection();
    var selectedText = selection.toString().trim();
    if (selectedText !== "") {
        // // Get the bounding client rect of the selection
        // var rect = selection.getRangeAt(0).getBoundingClientRect();

        // // Calculate the position for the popup
        // var popupX = rect.left + window.pageXOffset;
        // var popupY = rect.top + window.pageYOffset;

        // // Create and display the popup
        // var popup = document.createElement("div");
        // popup.textContent = "Options for '" + selectedText + "'";
        // popup.style.position = "absolute";
        // popup.style.top = popupY + "px";
        // popup.style.left = popupX + "px";
        // popup.style.background = "#f0f0f0";
        // popup.style.padding = "5px";
        // popup.style.border = "1px solid #ccc";
        // popup.style.zIndex = "9999";
        // document.body.appendChild(popup);

        // // Remove the popup after a short delay
        // setTimeout(function() {
        //     popup.parentNode.removeChild(popup);
        // }, 2000); // Adjust the delay as needed

        fetchData(selectedText)

    }
}

function VirtualPenn(){
    var htmlContent = document.getElementById("outline_holder").innerHTML;

    start = '<div class="outline_topic_block" id="outline_topic_block" name="outline_holder" data-placeholder="" data-editor-blockid="gpLqx0Uc2L" style="box-shadow: none;"></div>'
    htmlContent = htmlContent.replace(start, "")
    htmlContent = htmlContent.replaceAll('p>', '')  
    htmlContent = htmlContent.split('<')

    htmlContent.shift()

    buffer = [];
    let substring = "/";
    let substring1 = "Outline_Title"
    for (var i = 0; i < htmlContent.length; i++){
        if (!htmlContent[i].includes(substring) && !htmlContent[i].includes(substring1) && htmlContent[i] != ""){
            buffer.push(htmlContent[i]);
        }
    }
    htmlContent = buffer

    substring = "Outline_Main"
    substring1 = "br>"

    htmlContent.forEach((str, index) => {
        if (str.includes(substring)) {
            htmlContent.splice(index, 1)
        }
        if (str.includes(substring1)) {
            htmlContent[index] = "\n"
        }
    });

    let result = ''
    for (let i = 0; i < htmlContent.length; i++) {
        // Append the current element to the result string
        result += htmlContent[i]+"\n";
    }

    htmlContent = result

    console.log(htmlContent);
    OpenaiFetchAPI()

    

}

// VirtualPenn();

function OpenaiFetchAPI() {
    console.log("Calling GPT3")
    // var url = "https://api.openai.com/v1/models";
    // var bearer = 'Bearer ' + "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";
    // fetch(url, {
    //     method: 'POST',
    //     headers: {
    //         'Authorization': bearer,
    //         'Content-Type': 'application/json'
    //     },
    //     body: JSON.stringify({
    //         "prompt": "Once upon a time",
    //         "max_tokens": 5,
    //         "temperature": 1,
    //         "top_p": 1,
    //         "n": 1,
    //         "stream": false,
    //         "logprobs": null,
    //         "stop": "\n"
    //     })


    // }).then(response => {
        
    //     return response.json()
       
    // }).then(data=>{
    //     console.log(data)
    //     console.log(typeof data)
    //     console.log(Object.keys(data))
    //     console.log(data['choices'][0].text)
        
    // })
    //     .catch(error => {
    //         console.log('Something bad happened ' + error)
    //     });

    

}

// const endpointUrl = "https://api.openai.com/v1/models";

// // Header Parameters
// const headerParameters = {
//     "Authorization": "Bearer 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"
// };

// // Setting API call options
// const option = {
//     method: "GET",
//     headers: headerParameters
// };

// // Function to make API call
// async function getModels() {
//     try {
//     const response = await fetch(endpointUrl, option);

//     // Printing response
//     printResponse(response);
//     } catch (error) {
//     // Printing error message
//     printError(error);
//     }
// }

// // Calling function to make API call
// getModels();    

fetch('https://api.openai.com/v1/chat/completions', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Authorization': 'Bearer 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'
  },
  body: JSON.stringify({
    'model': 'gpt-3.5-turbo',
    'messages': [
      {
        'role': 'user',
        'content': 'Tell me a funny joke'
      }
    ]
  })
})

// async function openAI(){
//     console.log("Calling GPT3")
//     const url = 'https://api.openai.com/v1/chat/completions';
//     const options = {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'Authorization': 'Bearer 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'
//         },
//         body: JSON.stringify({
//             'model': 'gpt-3.5-turbo',
//             'messages': [
//             {
//                 'role': 'user',
//                 'content': 'Tell me a funny joke'
//             }
//             ]
//         })
//     };

//     try {
//         const response = await fetch(url, options);
//         const result = await response.text();
//         const parsedData = JSON.parse(result);
//         console.log(parsedData)
//     } catch (error){
//         console.error(error);
//     }
// }
async function openThread(){
    console.log("OpeningThread")
    const url = 'https://api.openai.com/v1/threads';
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer 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',
            'OpenAI-Beta' : 'assistants=v1'
        }
    };

    try {
        const response = await fetch(url, options);
        const result = await response.text();
        const parsedData = JSON.parse(result);
        console.log(parsedData)

        input = document.getElementById("thread_number");
        input.value = parsedData['id'];

        document.getElementById("Virtual_Assistant").submit();

    } catch (error){
        console.error(error);
    }
}


console.log(thread_id);

async function CreateMessage(Thread, Content){
    const url = 'https://api.openai.com/v1/threads/'+Thread+'/messages';
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer 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',
            'OpenAI-Beta' : 'assistants=v1'
        },
        body: JSON.stringify({
            'role': 'user',
            'content': Content
        })
    };

    try {
        const response = await fetch(url, options);
        const result = await response.text();
        const parsedData = JSON.parse(result);
        console.log("CreatingMessage")
        console.log(parsedData)
    } catch (error){
        console.error(error);
    }
}

async function sendMessage(Thread){
    console.log("Hello")
    const url = 'https://api.openai.com/v1/threads/'+Thread+'/runs';
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer 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',
            'OpenAI-Beta' : 'assistants=v1'
        },
        body: JSON.stringify({
            'assistant_id': 'asst_8D68KV63S4EYHwk1GuLcwQaZ',
            'instructions': 'You are a virtual AI assistant called VirtualPen the heart of a web-based app called ERRS(Essay writing and editing system) your functions are: To help the user brainstorm ideas for the essay; Advise the user on better grammar, sentence structure, and text cohesion; In some situations, you will have to rate the text on Correctness, Clarity, Engagement, Delivery, while also providing ideas on how to improve these aspects of the text; But your main goal and most important function is to teach and guide the user, wit the intention of improving their skills in all regards. One of your inherent limitations is the inability to create a full essay on behalf of the user. Whenever you are asked for information that can contribute to an essay, you provide helpful insights, but never enough to form a complete explanation of the idea or paragraph.'
        })
    };

    try {
        const response = await fetch(url, options);
        const result = await response.text();
        const parsedData = JSON.parse(result);
        console.log("SendingMessage");
        console.log(parsedData);
        // console.log(parsedData['status']);
        array = [parsedData['status'], parsedData['id']]
        return array;
    } catch (error){
        console.error(error);
    }
}

async function getStatus(Thread, Run){
    console.log("Hello")
    const url = 'https://api.openai.com/v1/threads/'+Thread+'/runs/'+Run; 
    const options = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer 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',
            'OpenAI-Beta' : 'assistants=v1'
        }
    };

    try {
        const response = await fetch(url, options);
        const result = await response.text();
        const parsedData = JSON.parse(result);
        console.log("RetrewingStatus");
        console.log(parsedData);
        // console.log(parsedData['status']);
        // array = [parsedData['status'], parsedData['id']]
        return parsedData['status'];
    } catch (error){
        console.error(error);
    }
}

async function ListMessages(Thread){
    const url = 'https://api.openai.com/v1/threads/'+Thread+'/messages';
    const options = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer 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',
            'OpenAI-Beta' : 'assistants=v1'
        }
    };

    try {
        const response = await fetch(url, options);
        const result = await response.text();
        const parsedData = JSON.parse(result);
        data = parsedData['data'];
        // data = data.slice(-1)
        console.log("ListMessages")
        console.log(data)
        // console.log(data['content'][0]['text']['value'])
        // console.log(data['status'])
        return data[0]['content'][0]['text']['value']
    } catch (error){
        console.error(error);
    }
}


async function SendMessageOpenAi(){
    div_container = document.getElementById('chat-text');

    Input = document.getElementById("user-input");
    Input_Text = Input.value;
    Input.value = '';

    div = document.createElement('div');
    div.classList.add('user-message');
    div.innerHTML = Input_Text;

    div_container.appendChild(div);

    Thread = thread_id;
    
    CreateMessage(Thread, Input_Text);

    // await CreateMessage();

    // sendMessage(Thread);

    array = await sendMessage(Thread);
    Status = array[0];
    run_id = array[1];
    
    while (Status != "completed"){
        Status = await getStatus(Thread, run_id);
        console.log(Status);
    }
    message = await ListMessages(Thread);
    console.log(message);

    div = document.createElement('div');
    div.classList.add('ai-message');
    div.innerHTML = message;

    div_container.appendChild(div);
    
}

