from fastapi import FastAPI

from scrapefbm import gimmeSomeFood

app = FastAPI()

@app.get("/{city_name}")
async def get_food(city_name: str) -> dict[str, str]:
    title, image, link = gimmeSomeFood(city_name)
    return {
        'title': title,
        'image': image,
        'link': link,
    }
