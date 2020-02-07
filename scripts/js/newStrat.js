/*var mapsMap = new Map();

    mapsMap.set('Bank', ["2F Executive Lounge / 2F CEO Office", "1F Staff Room / 1F Open Area", "1F Tellers' Office / 1F Archives", "B Lockers / B CCTV Room"]);
    mapsMap.set('Bartlett', ["2F Rowing Museum / 2F Trophy Room", "1F Kitchen / 1F Piano Room", "1F Reading Room / Library", "2F Classroom / Library"]);
    mapsMap.set('Border', ["1F Custom Inspections / 1F Supply Room", "1F Ventilation Room / 1F Workshop", "1F Bathroom / 1F Tellers", "2F Armory Lockers / 2F Archives"]);
    mapsMap.set('Chalet', ["2F Master Bedroom / 2F Office", "1F Bar / 1F Gaming Room", "B Wine Cellar / B Snowmile Garage", "1F Kitchen / 1F Trophy Room"]);
    mapsMap.set('Club house', ["2F Gym / 2F Bedroom", "2F CCTV Room / 2F Cash Room", "1F Bar / 1F Stock Room", "B Church / B Arsenal Room"]);
    mapsMap.set('Coastline', ["2F Hookah Lounge / 2F Billards Room", "2F Penthouse / 2F Theater", "1F Kitchen / 1F Service Entrance", "1F Blue Bar / 1F Sunrise Bar"]);
    mapsMap.set('Consulate', ["2F Consul Office / 2F Meeting Room", "1F Lobby / 1F Press Room", "B Archives / 1F Tellers", "B Cafeteria / B Garage"]);
    mapsMap.set('Favela', ["3F Packaging Room / 2F Meth Lab", "2F Football Bedroom / 2F Football Office", "2F Aunt's Bedroom / 1F Aunt's Apartement", "1F Biker's Apartement / 1F Biker's Bedroom"]);
    mapsMap.set('Fortress', ["2F Bedroom / 2F Commander's Office", "2F Dormitory / 2F Briefing Room", "1F Kitchen / 1F Cafeteria", "1F Hammam / 1F Sitting Room"]);
    mapsMap.set('Hereford', ["3F Ammo Storage / 3F Tractor Storage", "2F Master Bedroom / 2F Kids Bedroom", "1F Dining Room / 1F Kitchen", "B Fermentation Chamber / B Brewery"]);
    mapsMap.set('House', ["2F Kid's Bedroom / 2F Workshop", "1F Living Room / B Training Room", "B Training Room / B Garage", "DOESN'T EXIST"]);
    //not update -- mapsMap.set('Kafe', ["3F Bar / 3F Cocktail Lounge", "2F Fireplace Hall / 2F Mining Room", "2F Reading Room / 2F Fireplace Hall", "1F Kitchen Service / 1F Kittchen Cooking"]);
    mapsMap.set('Kanal', ["CC3F Server Room / CC3F Control Room", "CC2F Kitchen / CC2F Projector Room", "CG2F Coast Guard Office / CG2F Holding Room", "DOESN'T EXIST"]);
    mapsMap.set('Oregon', ["2F Kids Dorm / 2F Dorm Main Hall", "1F Kitchen / 1F Dining Hall", "B Laudry Room / B Supply Room", "1F Rear Stage / 2F Watch Tower"]);
    mapsMap.set('Outback', ["2F Laundry / 2F Games Room", "2F Party Room / 2F Office", "1F Nature Room / 1F Bushranger Room", "1F Compressor Room / 1F Gear Store"]);
    mapsMap.set('Plane', ["2F Meeting Room / 2F Executive Office", "2F Saff Secion / 2F Executive Bedroom", "1F Cargo Hold / 1F Luggage Hold", "DOESN'T EXIST"]);
    mapsMap.set('Skyscraper', ["2F Karaoke / 2F Tea Room", "2F Exhibition / 2F Work Office", "1F BBQ / 1F Kitchen", "1F Bedroom / 1F Bathroom"]);
    mapsMap.set('Theme park', ["2F Initiation Room / 2F Office", "2F Bunk / 2F Day Care", "1F Gargoyle / 1F Haunted Dining", "1F Drug Lab / 1F Drug Storage"]);
    mapsMap.set('Tower', ["2F Gift Shop / 2F Lantern Room", "2F Exhibit Room / 2F Media Center", "1F Tea Room / 1F Bar", "1F Restaurant / 1F Bird Room"]);
    mapsMap.set('Villa', ["2F Aviator Room / 2F Games Room", "2F Trophy Room / 2F Statuary Room", "1F Living Room / 1F Library", "1F Dining Room / 1F Kitchen"]);
    mapsMap.set('Yacht', ["4F Maps Room / 4F Cockpit", "2F Kitchen / 2F Engine Control", "2F Cafeteria / 2F Staff Dormitory", "1F Server Room / 1F Engine Storage"]);
*/
function actualizeImages(currentFloor)
{
    var map = document.getElementsByClassName("map");
    for(var k = 0; k < map.length; k++)
    {
        map[k].style.zIndex = -3;
    }
    document.getElementById("map"+currentFloor).style.zIndex = 1;
}

function addParam(map, mod, obj, fileName)
{
    document.forms["newStratForm"]["map"].value = map;
    document.forms["newStratForm"]["mod"].value = mod;
    document.forms["newStratForm"]["obj"].value = obj;
    document.forms["newStratForm"]["fileName"].value = fileName;
    document.forms["newStratForm"].submit();
}

function stratmake(map, mod, obj, fileName)
{
    document.forms["stratmakerForm"]["map"].value = map;
    document.forms["stratmakerForm"]["mod"].value = mod;
    document.forms["stratmakerForm"]["obj"].value = obj;
    document.forms["stratmakerForm"]["fileName"].value = fileName;
    document.forms["stratmakerForm"].submit();
}

/*-----------------ANIMATION---------------*/

function selectMod(strIn)
{
    var elmt1 = document.getElementById(strIn + "Img").style;
    var elmt2 = document.getElementById(strIn + "Select").style;
    var l = strIn == "atk" ? 220 : 480;
    var lend = strIn == "atk" ? 150 : 440;
    var w = 30; 
    var o = 0;

    elmt1.zIndex = 2;
    elmt2.zIndex = 1;
    var id = setInterval(frame, 5);

    function frame()
    {
        if (w == 40)
        {
            clearInterval(id);
        }
        else
        {
            if(l > lend)
            {
                l -= 10;
                elmt1.left = (l / 10) + "%";
            }

            if(w < 40)
            {
                w++;
                elmt1.width = w+"%";
            }

            if(o < 100)
            {
                o += 5;
                elmt2.opacity = (o / 100);
            }
        }
    }
}

function unselectMod(strIn)
{
    var elmt1 = document.getElementById(strIn + "Img").style;
    var elmt2 = document.getElementById(strIn + "Select").style;
    var l = strIn == "atk" ? 150 : 440;
    var lend = strIn == "atk" ? 220 : 480;
    var w = 40; 
    var o = 100;

    elmt1.zIndex = 0;
    elmt2.zIndex = -1;
    var id = setInterval(frame, 5);

    function frame()
    {
        if (w == 30)
        {
            clearInterval(id);
        }
        else
        {
            if(l < lend)
            {
                l += 10;
                elmt1.left = (l / 10) + "%";
            }

            if(w > 30)
            {
                w--;
                elmt1.width = w+"%";
            }

            if(o > 0)
            {
                o -= 5;
                elmt2.opacity = (o / 100);
            }
        }
    }
}

function onMap(strIn)
{
    var elmt = document.getElementById(strIn).style;
    elmt.border = "2px solid white";
}

function outMap(strIn)
{
    var elmt = document.getElementById(strIn).style;
    elmt.border = "2px solid black";
}