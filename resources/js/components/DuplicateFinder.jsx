import React, { useState } from 'react';

function DuplicateFinder() {

  const [array, setArray] = useState('');
  const [duplicates, setDuplicates] = useState([]);



  const handleArrayChange = (e) => {
    setArray(e.target.value);
  };

  const findDuplicates = () => {
    const parsedArray = array.split(',').map(Number);
    console.log(parsedArray);
  
    const foundDuplicates = [];
  
    for (let i = 0; i < parsedArray.length; i++) {
      const num = parsedArray[i];
  
      // Check if the element has been seen before
      if (parsedArray.indexOf(num, i + 1) !== -1 && foundDuplicates.indexOf(num) === -1) {
        foundDuplicates.push(num);
      }
    }
  
    setDuplicates(foundDuplicates);
  
    console.log(foundDuplicates);
  };

  return (
    <div>
      <h1>Find Duplicates</h1>

      <div>
        <label htmlFor="arrayInput">Enter Array (comma-separated): </label>
        <input
          type="text"
          id="arrayInput"
          value={array}
          onChange={handleArrayChange}
        />
      </div>
      <button onClick={findDuplicates}>Find Duplicates</button>
      <div>
      output:  <p>{duplicates.join(', ')}</p>
      </div>

    </div>
  );
}

export default DuplicateFinder;
