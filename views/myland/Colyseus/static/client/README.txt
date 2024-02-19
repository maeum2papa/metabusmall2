**client 규칙**   

--인벤토리--
|-asset-Images-player : 플레이어가 착용가능한 에셋 (spritesheet가 있는 에셋)
|-asset-Images-가구(예정)
| 규칙
|-새로 만든 spritesheet가 있는 에셋은 총 두개 폴더와 두개의 이미지가 필요합니다.
|-같은 이미지의 이름은 항상 같아야 합니다.  
|-ex) asset-Images-player-bottom-bottom_청바지.png || css-img-show-bottom-bottom_청바지.png || css-img-preview-bottom_청바지.png
|-각 폴더별로 에셋 타입을 분리했습니다.
|-css-img-show-* : 인벤토리 목록에 보여주는 에셋입니다. 에셋의 이미지의 위치는 항상 중앙이어야 합니다. 
|-css-img-preview-* : 인벤토리에서 착용시 보여줄 수 있는 preview에셋입니다. spritesheet와 같은 위치의 이미지가 필요합니다.