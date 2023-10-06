import React from 'react';
import ReactDOM from 'react-dom';
import AttendanceList from './components/AttendanceList.jsx';
import DuplicateFinder from './components/DuplicateFinder.jsx';

ReactDOM.render(<AttendanceList />, document.getElementById('challenge-1'));
ReactDOM.render(<DuplicateFinder />, document.getElementById('challenge-2'));
