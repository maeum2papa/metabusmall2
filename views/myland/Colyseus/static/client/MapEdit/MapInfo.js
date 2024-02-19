class MapInfo {
    inner = '';
    outer = '';
    office = '';
    education = '';


    maplist = '';
    currentmaplist = '';

    objlist = '';
    currentobjlist = '';

    privatelist = '';
    currentprivatelist = '';

    videoname = '';
    videolist = '';


    sheetlist = '';
    currentsheetlist = '';
    currentsheetobjlist = '';

    templetelist = '';
    currenttempletelist = '';
    
    teleportlist = '';
    teleporttype = {};

    popuplist = '';
    popuptype = {};

    currentmapinfo = {};
    currentmapdepth = -1;

    currentMapName = {};
    currentMapDepth = {};
    currentObjName = {};
    currentObjDepth = {};
    currentSheetName = {};
    currentSheetObjName = {};
    currentVideoName = {};

    arrMap = [];

    mapRoute = {};
    objRoute = {};
    mapSprites = {};
    objSprites = {};
    sheetSprites = {};
    videoSprites = {};
    curspr = [];
    curObjSprite = null;
    curSheetSprite = null;
    curVideoSprite = null;

    mapSprite = null;
    mapHeight = 0;
    mapMaxHeight = 0;
    mapHalfHeight = 0;
    mapWidth = 0;
    mapMaxWidth = 0;
    mapHalfWidth = 0;
    mapdepthrange = {};

    constructor(context) {
        this.arrMap.push(this.inner, this.outer, this.office, this.education);
        this.currentMapName[''] = '';
        this.currentObjName[''] = '';
        this.objSprites[''] = '';
        this.sheetSprites[''] = '';
        this.videoSprites[''] = '';
        this.currentSheetName[''] = '';
        this.currentSheetObjName[''] = '';
        this.currentVideoName[''] = '';
   

        for (let i = 1; i < 10; ++i) {
            this.mapdepthrange[i * -1] = i * -1;
        }
        
        for (let i = 11; i < 20; ++i) {
            this.mapdepthrange[i] = i;
        }


        this.mapHeight = 0;
        this.mapMaxHeight = 0;
        this.mapHalfHeight = 0;
        this.mapWidth = 0;
        this.mapMaxWidth = 0;
        this.mapHalfWidth = 0;
        
    }

}