/*****
 * file: js2.js
 * description: test script file #2
 *****/

// add a calcAge method to the Dateobj
Date.prototype.calcAge = function () {
    // decompose two dates into year, month and date
    var dobComponents = getDateComponents(this);
    var todayComponents = getDateComponents(new Date());
    
    var age = todayComponents.year - dobComponents.year;
    
    // if today's month and date both must be greater than or equal to those of today
    // otherwise subtact one from  the age
    if ((todayComponents.month < dobComponents.month) || (todayComponents.month == dobComponents.month && todayComponents.date < dobComponents.date)) {
        --age;
    }
    
    return age;
    
    // function get year, month and day components from a date object
    // @param: dateobj -> object (Date)
    function getDateComponents(dateobj) {
        // argument must be a date object
        if (((typeof dateobj).toLowerCase() != "object") || dateobj.constructor.name != "Date") {
            return null;
        }

        // remember getMonth() returns the month index, starting zero
        var components = {year : dateobj.getFullYear(), month : dateobj.getMonth() + 1, date : dateobj.getDate() };

        return components;
    }    
};


/*
 * test class (base)
 */
class Person {
    
    constructor (id, name, username, email, address, phone) {
        this.id = id;
        this.name = name;
        this.username = username;
        this.email = email;
        this.address = address || null;
        this.phone = phone;
    }
    
    // getter
    get fulladdress() {
        return this.getFullAddress();
    }
    
    getFullAddress() {
        var fulladdress = "";
        
        for (let key in this.address) {
            // we don't need geo info
            if (key == "geo") {
                continue;
            }
            fulladdress += this.address[key];
            
            // append comma to the address (except city)
            fulladdress += (key != "city") ? ", " : " ";
        }
            
        // remove the trailing comma
        fulladdress = fulladdress.replace(/,\s*$/, "");
        return fulladdress.trim();
        
    }
    
    // getter
    get latLng() {
        this.getLatLng();
    }
    
    
}

/*
 * test derived class
 */
class User extends Person {
    constructor (id, name, username, email, address, phone, website, company) {
        super(id, name, username, email, address, phone);
        this.website = website;
        this.company = company || null;
    }
    
    /* instantiate from a data object */
    static instFromObj (obj) {
        if ((typeof obj).toLowerCase() != "object") {
            return null;
        }
        
        var userInstance = new User(
            obj.id          || null,
            obj.name        || null,
            obj.username    || null,
            obj.email       || null,
            obj.address     || null,
            obj.phone       || null,
            obj.website     || null,
            obj.company     || null
        );
        
        return userInstance;
    }
    
    static async getUserData() {
        const URL = "./users.json";
        let response = await fetch(URL);
        
        if (response.ok) {
            const data = await response.json();
            return Promise.resolve(data);
        }
        else {
            return Promise.reject(response);
        }   
    }
    
    static get EMAIL() {
        return "email";
    }
    
    static get WEB() {
        return "web";
    }
    
    get companyName() {
        return (this.company.name ? this.company.name : null);
    }
        
    get htmlDataRow() {
        return this.generateHtmlDataRow();
    }
    
    generateHtmlDataRow() {
        var datacells = [
            this.id,
            this.name,
            this.username,
            this.generateLink(User.EMAIL, this.email),
            this.fulladdress,
            this.phone,
            this.generateLink(User.WEB, this.website, "_blank"),
            this.companyName
        ];
        
        return "<tr><td>" + datacells.join("</td><td>") + "</td></tr>";
        
    }
    
    generateLink(type, address, target) {
        if (!address) {
            return "";
        }
        
        var ismailto = (type == User.EMAIL);
        
        return '<a href="' + (ismailto ? "mailto:" : "") + address + '" targe="' + (target ? target : "") + '">' + address + "</a>";
        
    }
    
}

function displayData(targetElemId) {
    var userdata = User.getUserData();
    
    userdata
    .then(data => {
        let datarows = [];
      
        for (let index = 0, userdata; userdata = data[index]; index++) {
            let user = User.instFromObj(userdata);
            datarows.push(user.htmlDataRow);
        }
        
        var target = document.getElementById(targetElemId);
        target.innerHTML = '<table border="1">' + datarows.join("") + "</table>";    
        
    })
    .catch(err => {
        alert(err.statusText);
        console.log(err.statusText);
    });
}


window.addEventListener(
    "load",
    function () {
        displayData("dataarea");
    },
    false
);



