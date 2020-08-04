function shuffle(arr) {
    // create a copy of the original array and prepare the new one
    let holder = arr;
    let newArray = [];

    do {
        // get a random position of the holder
        random = Math.floor(Math.random() * holder.length);

        //add the value of that position to the new array
        newArray.push(holder[random]);

        // remove the position of the holder
        holder = holder.filter((v, k) => k !== random);
    } while (holder.length > 0);

    return newArray;
}

// the original array needs at least 2 elements
let originalArray = new Array(1, 2, 3, 4, 5, 6);

console.log(shuffle(originalArray));
