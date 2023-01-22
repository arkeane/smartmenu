function genDescription(token) {
    
    var product_name = document.getElementById("productname").value;
    var product_description = document.getElementById("product_description").value;
    
    document.getElementById("product_description").value = "Generating description...";
    document.getElementById("ai_desc").hidden = true;

    // the url to make the request to
    var url = "https://api.openai.com/v1/completions";
    // the settings for the request
    var settings = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token,
        },
        body: JSON.stringify({
            "model": "text-davinci-003",
            "prompt": "Create a description max 140 chars describing " + product_name + " " + product_description + ", try to make it appealing to the customer",
            "max_tokens": 200,
            "temperature": 1
        })
    };        

    // call the API
    fetch(url, settings)
    // get the response
    .then(response => response.json())
    // get the text
    .then(data => {
        var text = data.choices[0].text;
        // set the text to the description field
        document.getElementById("product_description").value = text;
        document.getElementById("ai_desc").hidden = false;
    })
    // catch any errors
    .catch(err => {
        console.error(err);
    }
    );


}