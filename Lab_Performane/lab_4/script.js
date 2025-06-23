const students= [
    {
        name:"Tanvir",
        roll:123,
        subject_scores:{
            Bangla:70,
            English: 80,
            CSE115: 90,
            MAT101: 95,
        },
        attd: true,

    },
    {
        name:"Ahammed",
        roll:45,
        subject_scores:{
            Bangla:65,
            English: 75,
            CSE115: 85,
            MAT101: 90,
        },
        attd: false,

    },
    {
        name:"Bipul",
        roll:67,
        subject_scores:{
            Bangla:80,
            English: 82,
            CSE115: 92,
            MAT101: 95,
        },
        attd: true,

    },
    {
        name:"Robin",
        roll:89,
        subject_scores:{
            Bangla:60,
            English: 55,
            CSE115: 75,
            MAT101: 80,
        },
        attd: false

    },
]

for (let i = 0; i < students.length; i++) {
    const student = students[i];
    
    if (!student.attd) {
        console.log(`${student.name} (roll: ${student.roll}): not eligible`);

    } else {


    }
   
}