import React, { useEffect, useState } from 'react';
import axios from 'axios';

function AttendanceList() {
  const [attendanceData, setAttendanceData] = useState([]);

  useEffect(() => {
    // Make an API request to fetch attendance data from Laravel backend
    axios.get('/api/attendance')
      .then((response) => {
        setAttendanceData(response.data);
      })
      .catch((error) => {
        console.error('Error fetching attendance data:', error);
      });
  }, []);

  return (
    <div>
      <h1>Attendance List</h1>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Total Working Hours</th>
          </tr>
        </thead>
        <tbody>
          {attendanceData.map((attendance) => (
            <tr key={attendance.id}>
              <td>{attendance.name}</td>
              <td>{attendance.checkin || 'N/A'}</td>
              <td>{attendance.checkout || 'N/A'}</td>
              <td>{attendance.total_working_hours}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default AttendanceList;
