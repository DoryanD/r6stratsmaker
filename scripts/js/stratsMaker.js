var imagesList = [];
var nbImagePlaced = {
    total : 0,
    operators : 0,
    abilities : 0,
    gadgets : {
        barbedwire : 0,
        bulletproofcamera : 0,
        c4 : 0,
        impactgrenade : 0,
        shield : 0,
        breachcharge : 0,
        claymore : 0,
        flashgrenade : 0,
        fraggrenade : 0,
        smokegrenade : 0,
        total: 0
    },
    other : {
        rotation : 0,
        reinforcedWall : 0,
        drone: 0,
        defuser: 0,
        total: 0
    }
};
var map = "";
var mod = "";
var obj = "";
var fileName = "";
var jsonStr = "";
var saved = 0;
var lastRotateValue = 0;
var mapX = 0;
var mapY = 0;
var roofMax = 0;
var timeToSave = 10;
var currentFloor = 0;
var currentRotation = 0;
var currentNbRt = 0;
var currentNbRW = 0;
var currentNbD = 0;
var currentNbDf = 0;
var currentNbOP = 0;
var currentNbAb = 0;
var currentNbGd = 0;
var currentNbOt = 0;
var interv1 = null;
var interv4 = null;
var animating = 0;

function init(str1, str2, str3, str4, str5)
{
    map = str1; mod = str2; obj = str3; fileName = str4; roofMax = str5;
    mapX = Math.round(.69 * screen.availWidth * 10) / 10;
    mapY = Math.round(.88 * screen.availHeight * 10) / 10;
    document.getElementById("contentList").value = "";

    interv1 = setInterval(saveData, timeToSave * 60 * 1000);
}

class Image
{
    constructor(_type, _name, _coords, _id, _size, _floor, _zindex, _rotateIndex)
    {
        if(_type == "get")
            return this;
        this.type = _type;
        this.referenceName = _name.replace("-img", "");
        switch(this.type)
        {
            case 'operator':
                if(currentNbOP < 10)
                { 
                    this.index = nbImagePlaced.operators;
                    nbImagePlaced.operators += 1;
                    currentNbOP += 1;
                }
                else
                {
                    setMsg("ERROR", "Too many operators");
                    return null;
                }
            break;
            case 'gadget':
                if(currentNbGd < 30)
                { 
                    if(this.referenceName == "Barbed wire"){this.index = nbImagePlaced.gadgets.barbedwire; nbImagePlaced.gadgets.barbedwire += 1;}
                    if(this.referenceName == "Bulletproof camera"){this.index = nbImagePlaced.gadgets.bulletproofcamera; nbImagePlaced.gadgets.bulletproofcamera += 1;}
                    if(this.referenceName == "C4"){this.index = nbImagePlaced.gadgets.c4; nbImagePlaced.gadgets.c4 += 1;}
                    if(this.referenceName == "Impact grenade"){this.index = nbImagePlaced.gadgets.impactgrenade; nbImagePlaced.gadgets.impactgrenade += 1;}
                    if(this.referenceName == "Shield"){this.index = nbImagePlaced.gadgets.shield; nbImagePlaced.gadgets.shield += 1;}

                    if(this.referenceName == "Breach charge"){this.index = nbImagePlaced.gadgets.breachcharge; nbImagePlaced.gadgets.breachcharge += 1;}
                    if(this.referenceName == "Claymore"){this.index = nbImagePlaced.gadgets.claymore; nbImagePlaced.gadgets.claymore += 1;}
                    if(this.referenceName == "Flash grenade"){this.index = nbImagePlaced.gadgets.flashgrenade; nbImagePlaced.gadgets.flashgrenade += 1;}
                    if(this.referenceName == "Frag grenade"){this.index = nbImagePlaced.gadgets.fraggrenade; nbImagePlaced.gadgets.fraggrenade += 1;}
                    if(this.referenceName == "Smoke grenade"){this.index = nbImagePlaced.gadgets.smokegrenade; nbImagePlaced.gadgets.smokegrenade += 1;}
                    this.index = currentNbGd;
                    currentNbGd += 1;
                }
                else
                {
                    setMsg("ERROR", "Too many gadgets");
                    return null;
                }
            break;
            case 'rotation':
                if(currentNbRt < 20)
                { 
                    this.index = currentNbOt;
                    nbImagePlaced.other.rotation += 1;
                    currentNbRt += 1;
                    currentNbOt += 1;
                }
                else
                {
                    setMsg("ERROR", "Too many rotation");
                    return null;
                }
            break;
            case 'reinforcedwall':
                if(currentNbRW < 10)
                { 
                    this.index = currentNbOt;
                    nbImagePlaced.other.reinforcedWall += 1;
                    currentNbRW += 1;
                    currentNbOt += 1;
                }
                else
                {
                    setMsg("ERROR", "Too many reinforced wall");
                    return null;
                }
            break;
            case 'drone':
                if(currentNbD < 10)
                { 
                    this.index = currentNbOt;
                    nbImagePlaced.other.drone += 1;
                    currentNbOt += 1;
                    currentNbD += 1;
                }
                else
                {
                    setMsg("ERROR", "Too many drones");
                    return null;
                }
            break;
            case 'defuser':
                if(currentNbDf < 1)
                { 
                    this.index = currentNbOt;
                    nbImagePlaced.other.defuser += 1;
                    currentNbDf += 1;
                    currentNbOt += 1;
                }
                else
                {
                    setMsg("ERROR", "Can't add more than 1 defuser");
                    return null;
                }
            break;
            case 'abilitie':
                if(currentNbAb < 57/*TODO + la spé de Buck*/)
                { 
                    this.index = nbImagePlaced.abilities;
                    nbImagePlaced.abilities += 1;
                    currentNbAb += 1;
                }
                else
                {
                    setMsg("ERROR", "Too many abilities");
                    return null;
                }
            break;
        }
        nbImagePlaced.gadgets.total = nbImagePlaced.gadgets.barbedwire + nbImagePlaced.gadgets.bulletproofcamera + nbImagePlaced.gadgets.c4 + nbImagePlaced.gadgets.impactgrenade + nbImagePlaced.gadgets.shield +
                                      nbImagePlaced.gadgets.breachcharge + nbImagePlaced.gadgets.claymore + nbImagePlaced.gadgets.flashgrenade + nbImagePlaced.gadgets.fraggrenade + nbImagePlaced.gadgets.smokegrenade;
        nbImagePlaced.other.total = nbImagePlaced.other.rotation + nbImagePlaced.other.reinforcedWall + nbImagePlaced.other.drone + nbImagePlaced.other.defuser + nbImagePlaced.abilities;
        
        nbImagePlaced.total = nbImagePlaced.operators + nbImagePlaced.abilities + nbImagePlaced.gadgets.total + nbImagePlaced.other.total;
                            
        this.name = _name;
        if(this.index < 10){
            this.id = _id+"-00"+this.index;
        }
        else if(this.index < 100)
        {
            this.id = _id+"-0"+this.index;
        }
        else
        {
            this.id = _id+"-"+this.index;
        }
        this.coords = _coords;
        this.size = _size;
        this.floor = _floor;
        this.zIndex = _zindex;
        this.rotateIndex = _rotateIndex;
        this.exists = true;
        saved = 0;
        setupImage(this);
    }
}

function newImage(_type, _name)
{
    var coordsbase = [50, 50];
    var sizebase = [30, 30];
    var _newImage = new Image(_type, _name+"-img", coordsbase, _name, sizebase, currentFloor, 1, 0);
    if(_newImage.exists)
    {
        imagesList.push(_newImage);
        actualizeContentList();
    }
}

function setupImage(_obj)
{
    var para = document.createElement("img");
    para.id = _obj.id;
    para.name = "imageOnTheMap";
    if(_obj.type == "rotation" || _obj.type == "reinforcedwall" || _obj.type == "drone")
    {
        para.src = "../../UI/img/"+_obj.type+"/"+_obj.referenceName+_obj.rotateIndex+".png";
    }
    else if(_obj.type == "abilitie")
    {
        para.src = "../../UI/img/"+_obj.type+"/src/"+_obj.referenceName+".png";
    }
    else
    {
        para.src = "../../UI/img/"+_obj.type+"/"+_obj.referenceName+".png";
    }
    para.onclick = function selectImgCaller(event){selectImg(_obj.id)};
    para.floor = _obj.floor;
    para.rotateIndex = _obj.rotateIndex;
    var tmpelmt = document.getElementById("mapdiv").appendChild(para);
    var stl = tmpelmt.style;
    stl.position = "absolute";
    stl.transform = "translate(-50%, -50%)";
    stl.zIndex = _obj.zIndex;
    selectImg(_obj.id);
    doTranslation(_obj.coords, _obj.id);
    doResize(_obj.size);
    actualizeImages();
}

function selectImg(_id)
{
    document.getElementsByName("imageOnTheMap").forEach(unselect);
    var _obj = document.getElementById(_id);
    _obj.style.border = "1px solid orangered";
    _obj.onclick = function moveImgCaller(event){
            unselect(this);
            document.getElementById("map"+currentFloor).onclick = function moveImgCaller(_event){moveImg(event, "none")};
            };
    document.getElementById("map"+currentFloor).onclick = function moveImgCaller(event){moveImg(event, _obj.id)};
    if(_obj.floor != currentFloor)
    {
        goToFloor(_obj.floor);
    }
}

function unselect(_item)
{
    _item.style.border = "1px solid rgba(0, 0, 0, 0)";
    _item.onclick = function selectImgCaller(event){selectImg(_item.id)};
}

function doTranslation(_coords, _id)
{
    var _obj = document.getElementById(_id);
    _obj.style.left = _coords[0] + "%";
    _obj.style.top = _coords[1] + "%";
}

function doResize(_size)
{
    var currentImg = document.getElementById(getSelectedImage(0));
    currentImg.size = _size;
    currentImg.style.width = currentImg.size[0] + "px";
    currentImg.style.height = currentImg.size[1] + "px";
}

function moveImg(_event, _id)
{
    if(_id != "none")
    {
        var _obj = document.getElementById(_id);
        var x = _event.clientX * 100 / screen.availWidth;
        var y = ((_event.offsetY) + (screen.height * .12 / 2)) * 100 / mapY;
        _obj.coords = [x, y];
        doTranslation(_obj.coords, _obj.id);
    }
}

function deleteImage()
{
    var parent = document.getElementById("mapdiv");
    var child = document.getElementById(getSelectedImage(0));
    var _type = getSelectedImageType();
    switch(_type)
    {
        case "operator":
            currentNbOP -= 1;
        break;
        case "gadget":
            currentNbGd -= 1;
        break;
        case "reinforcedwall":
            currentNbRW -= 1;
        break;
        case "rotation":
            currentNbRt -= 1;
        break;
        case "drone":
            currentNbD -= 1;
        break;
        case "defuser":
            currentNbDf -= 1;
        break;
        case "abilitie":
            currentNbAb -= 1;
        break;
    }
    parent.removeChild(child);
    imagesList.splice(getSelectedImage(1), 1);
    actualizeContentList();
}

function getSelectedImage(_mod)
{
    var item = document.getElementsByName("imageOnTheMap");
    for(var i = 0; i < item.length; i++)
    {
        if(item[i].style.border == "1px solid orangered")
        {
            switch(_mod)
            {
                case 0:
                    return item[i].id;
                break;
                case 1:
                    return i;
                break;
            }
        }
    }
    return null;
}

function actualizeObjectData(attr, value)
{
    for(var i = 0; i < imagesList.length; i++)
    {
        if(imagesList[i].id == getSelectedImage(0))
        {
            imagesList[i][attr] = value;
        }
    }
}

function getSelectedImageType()
{
    var item = document.getElementsByName("imageOnTheMap");
    for(var i = 0; i < item.length; i++)
    {
        var arr = item[i].src.split("/");
        var _type = "";
        for(var k = 0; k < arr.length; k++)
        {
            if(arr[k] == "img")
            {
                _type = arr[k + 1];
            }
        }
        if(item[i].style.border == "1px solid orangered")
        {
            return _type;
        }
    }
    return null;
}

function resize(way)
{
    var currentImg = document.getElementById(getSelectedImage(0));
    var maxValue = 90;
    var minValue = 15;
    var newValue = currentImg.size[0] + (5 * way);
    if(newValue >= maxValue)
    {
        newValue = maxValue;
    }
    else if(newValue <= minValue)
    {
        newValue = minValue;
    }

    var newVals = [newValue, newValue];
    doResize(newVals);
}

function rotate(way)
{
    document.getElementById("imgPropertiesMsg").innerHTML = "";
    var currentType = getSelectedImageType();
    if(currentType == "drone" || currentType == "rotation" || currentType == "reinforcedwall")
    {
        var currentImg = document.getElementById(getSelectedImage(0));
        var str = currentImg.id.slice(0, -4).replace(" ", "").toLowerCase();
        var maxValue = 0;
        maxValue = mod == "atk" ? 180 : 90;
        var newValue = currentImg.rotateIndex + (9 * way);
        currentImg.rotateIndex = (newValue < maxValue && newValue > -maxValue) ? newValue : (-maxValue * way);
        currentImg.src = "../../UI/img/" + str + "/" + currentImg.id.slice(0, -4) + currentImg.rotateIndex + ".png";
    }
    else
    {
        document.getElementById("imgPropertiesMsg").innerHTML = "Can't rotate this " + currentType;
    }
}

function saveData()
{
    if(nbImagePlaced.total > 0)
    {
        var tmp = 
        {
            id : "",
            type : "",
            name : "",
            src : "",
            floor : "",
            rotateIndex : "",
            style : {
                position : "",
                transform : "",
                left : "",
                top : "",
                width : "",
                height : "",
                zIndex : ""
            },
            onclick : ""
        };
        var txt = "";
        var item = document.getElementsByName("imageOnTheMap");
        var source = "";
        for(var i = 0; i < item.length; i++)
        {
            var arr = item[i].src.split("/");
            for(var k = 0; k < arr.length; k++)
            {
                if(arr[k] == "img")
                {
                    source = arr[k] + "/" + arr[k + 1] + "/" + arr[k + 2];
                    tmp.type = arr[k + 1];
                }
            }
            if(i < 10)
            {
                tmp.id = item[i].id.slice(0, -4)+"-00"+i;
            }
            else if(i < 100)
            {
                tmp.id = item[i].id.slice(0, -4)+"-0"+i;
            }
            else
            {
                tmp.id = item[i].id.slice(0, -4)+"-"+i;
            }
            tmp.name = "imageOnTheMap";
            tmp.src = source.replace(item[i].rotateIndex, "");
            tmp.floor = item[i].floor;
            tmp.rotateIndex = item[i].rotateIndex;
            tmp.style.position = item[i].style.position;
            tmp.style.transform = item[i].style.transform;
            tmp.style.left = Math.round(parseFloat(item[i].style.left.slice(0, -1) * 10)) / 10;
            tmp.style.top = Math.round(parseFloat(item[i].style.top.slice(0, -1) * 10)) / 10;
            tmp.style.width = item[i].style.width.slice(0, -2);
            tmp.style.height = item[i].style.height.slice(0, -2);
            tmp.style.zIndex = item[i].style.zIndex;
            tmp.onclick = item[i].onclick;
            txt = txt + JSON.stringify(tmp);
            if(item.length > 1 && i < item.length - 1)
            {
                txt = txt+", ";
            }
        }
        document.forms["jsonform"]["jsonTxt"].value = "{\"map\" : \""+map+"\", "+
        "\"mod\" : \""+mod+"\", "+
        "\"obj\" : \""+obj+"\", "+
        "\"nbImagesPlaced\" : " + JSON.stringify(nbImagePlaced) + ", " + 
        "\"images\" : [" + txt + "]}";
        document.forms["jsonform"].submit();
    }
}

function endOfTransmission(strIn)
{
    jsonStr = "";
    var charList = strIn.split("");
    for(var j = 0; j < charList.length; j++)
    {
        if(charList[j] !== "¤")
        {
            jsonStr += charList[j];
        }
        else
        {
            jsonStr += '"';
        }
    }
    var elmntToSuppr = document.getElementsByClassName("tosuppr");
    var elmntLeng = elmntToSuppr.length;
    for(var i = 0; i < elmntLeng; i++)
    {
        document.getElementById("body").removeChild(document.getElementById("tosuppr"));
    }
    jsonStr = JSON.parse(jsonStr);
    map = jsonStr["map"];
    mod = jsonStr["mod"];
    obj = jsonStr["obj"];
    fileName = jsonStr["fileName"];
    var k = 0;
    var kmax = jsonStr["images"].length;
    interv4 = setInterval(loading, 1);
    var loadingProgress = document.getElementById("loadingProgress");

    function loading()
    {
        if(k >= kmax)
        {
            clearInterval(interv4);
            stopLoading();
            saved = 1;
        }
        else
        {
            var percent = k * 100 / kmax;
            loadingProgress.style.width = percent + "%";
            loadingProgress.style.left = percent / 2 + "%";
            var _coords_ = [jsonStr["images"][k].style.left, jsonStr["images"][k].style.top];
            var _size_ = [parseFloat(jsonStr["images"][k].style.width), parseFloat(jsonStr["images"][k].style.height)];
            var _zindex_ = jsonStr["images"][k].style.zIndex;
            var _rotateIndex_ = jsonStr["images"][k].rotateIndex;
            imagesList.push(new Image(jsonStr["images"][k].type, jsonStr["images"][k].id.slice(0, -4), _coords_, jsonStr["images"][k].id.slice(0, -4), _size_, jsonStr["images"][k].floor, _zindex_, _rotateIndex_));
            actualizeContentList();
            k++;
        }
    }
}

function gotoIndex()
{
    if(saved == 0)
    {
        var leaveWOsave = confirm("Go without save ?");
        if(leaveWOsave)
            location.href = "../../index.php";
    }
    else
    {
        location.href = "../../index.php";
    }
}

function goToFloor(x)
{
    currentFloor = x;
    actualizeImages();
}

function upperFloor()
{
    if(currentFloor + 1 <= roofMax)
        currentFloor++;

    actualizeImages();
}

function lowerFloor()
{
    if(currentFloor - 1 >= 0)
        currentFloor--;

    actualizeImages();
}

function actualizeImages()
{
    var _map = document.getElementsByClassName("map");
    for(var k = 0; k < _map.length; k++)
    {
        _map[k].style.zIndex = -3;
    }
    document.getElementById("map"+currentFloor).style.zIndex = -1;
    var item = document.getElementsByName("imageOnTheMap");
    for(var i = 0; i < item.length; i++)
    {
        if(item[i].floor == currentFloor)
            item[i].style.zIndex = 1;
        else if(item[i].floor != currentFloor)
            item[i].style.zIndex = -1;
    }
    if(getSelectedImage(0) != null)
    {
        document.getElementById(getSelectedImage(0)).style.zIndex = 1;
        document.getElementById(getSelectedImage(0)).floor = currentFloor;
        actualizeObjectData("floor", currentFloor);
    }
}

function swapImg(_id)
{
    document.getElementsByName("imageOnTheMap").forEach(unselect);
    selectImg(_id);
}

function actualizeContentList()
{
    var str = "";

    str += "<dt>Operators</dt>\n";
        str += "<dd>" + nbImagePlaced.operators + "</dd>\n";

    str += "<dt>Gadgets</dt>\n";
        if(mod == "def")
        {
            str += "<dd>Barbed wire : " + nbImagePlaced.gadgets.barbedwire + "</dd>\n";
            str += "<dd>Bullet proof camera : " + nbImagePlaced.gadgets.bulletproofcamera + "</dd>\n";
            str += "<dd>C4 : " + nbImagePlaced.gadgets.c4 + "</dd>\n";
            str += "<dd>Impact grenade : " + nbImagePlaced.gadgets.impactgrenade + "</dd>\n";
            str += "<dd>Shield : " + nbImagePlaced.gadgets.shield + "</dd>\n";
        }
        else
        {
            str += "<dd>Breach charge : " + nbImagePlaced.gadgets.breachcharge + "</dd>\n";
            str += "<dd>Claymore : " + nbImagePlaced.gadgets.claymore + "</dd>\n";
            str += "<dd>Flash grenade : " + nbImagePlaced.gadgets.flashgrenade + "</dd>\n";
            str += "<dd>Frag grenade : " + nbImagePlaced.gadgets.fraggrenade + "</dd>\n";
            str += "<dd>Smoke grenade : " + nbImagePlaced.gadgets.smokegrenade + "</dd>\n";
        }

    str += "<dt>Abilities</dt>\n";
        str += "<dd>" + nbImagePlaced.abilities + "</dd>\n";

    str += "<dt>Other</dt>\n";
        if(mod == "def")
        {
            str += "<dd>Reinforced wall : " + nbImagePlaced.other.reinforcedWall + "</dd>\n";
            str += "<dd>Rotation : " + nbImagePlaced.other.rotation + "</dd>\n";
        }
        else
        {
            str += "<dd>Drone : " + nbImagePlaced.other.drone + "</dd>\n";
            str += "<dd>Defuser : " + nbImagePlaced.other.defuser + "</dd>\n";
        }
    document.getElementById("contentList").innerHTML = str;

}

function tabsManager(tag1, tag2)
{
    var selected = document.getElementById(tag1);
    var old = document.getElementById(tag2);

    selected.classList = "tabText selected";
    old.classList = "tabText";

    document.getElementById(tag1.replace("Tab", "")).style.visibility = "visible";
    document.getElementById(tag2.replace("Tab", "")).style.visibility = "hidden";
}

function setMsg(_type, _msg)
{
    var msgBox = document.getElementById("msgBox");
    var msgTxt = document.getElementById("msgTxt");
    msgTxt.classList = _type;
    msgTxt.innerHTML = _msg;
    var a = 0;
    var aend = 95;

    var interv2 = null;
    var interv3 = null;

    if(animating == 0){ interv2 = setInterval(frame, 1); }

    function frame()
    {
        animating = 1;
        if(a > aend)
        {
            msgTxt.style.visibility = "visible";
            a = aend * 3;
            aend = 0;
            interv3 = setInterval(frame2, 20);
            clearInterval(interv2);
        }
        else
        {
            if(a < aend)
            {
                if(a >= 70){ msgTxt.style.visibility = "visible"; }
                msgBox.style.backgroundColor = "rgba(80, 80, 80, " + (a / 100) + ")";
                a += 5;
            }
        }
    }

    function frame2()
    {
        animating = 1;
        if(a < aend)
        {
            animating = 0;
            clearInterval(interv3);
        }
        else
        {
            if(a > aend && a <= 95)
            {
                if(a <= 70){ msgTxt.style.visibility = "hidden"; }
                msgBox.style.backgroundColor = "rgba(80, 80, 80, " + (a / 100) + ")";
                a -= 5;
            }
            else if(a > aend && a > 95)
            {
                a -= 5;
            }
        }
    }
}

function stopLoading()
{
    document.getElementById("body").removeChild(document.getElementById("loadingBox"));
}