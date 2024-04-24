fetch("index.php")
    .then((response) => {
        if(!response.ok){ // Before parsing (i.e. decoding) the JSON data,
                        // check for any errors.
            // In case of an error, throw.
            throw new Error("Something went wrong!");
        }

        return response.json(); // Parse the JSON data.
    })
    .then((data) => {
        console.log("hI")
        // This is where you handle what to do with the response.
        alert(data); // Will alert: 42
    })
    .catch((error) => {
        // This is where you handle errors.
    });