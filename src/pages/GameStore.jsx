import React, { useState } from "react"
import ViewGameStore from "../components/gameStoreComponents/ViewGameStore"
import { Carousel } from "react-responsive-carousel"
import "react-responsive-carousel/lib/styles/carousel.min.css"

function GameStore() {
  const [checker, setChecker] = useState(false)


  return (
    <div className="game-store-container">
      <div className="carousel-container w-85 opacity-75 hover:opacity-100">
        <Carousel
          showArrows={true}
          showStatus={false}
          showIndicators={true}
          showThumbs={false}
          infiniteLoop={true}
          autoPlay={true}
          interval={2000} // 2-second interval
        >         
            <img className="h-98"
              src="https://nsnoztviefjxvptztmnj.supabase.co/storage/v1/object/public/item_pics/background/Main%20Menu.png"
              alt="Main Menu"
            />     
            <img className="h-98"
              src="https://nsnoztviefjxvptztmnj.supabase.co/storage/v1/object/public/item_pics/background/image%2021.png"
              alt="Map"
            />
            <img className="h-98"
              src="https://nsnoztviefjxvptztmnj.supabase.co/storage/v1/object/public/item_pics/background/Level%201%20Tutorial.png"
              alt="Tutorial"
            />
            <img
              className="h-98"
              src="https://nsnoztviefjxvptztmnj.supabase.co/storage/v1/object/public/item_pics/background/Victory.png"
              alt="Victory"
            />
            <img className="h-98"
              src="https://nsnoztviefjxvptztmnj.supabase.co/storage/v1/object/public/item_pics/background/Level%205%20Boss%20Stage.png"
              alt="Boss Stage"
            />
            <img className="h-98"
              src="https://nsnoztviefjxvptztmnj.supabase.co/storage/v1/object/public/item_pics/background/Shops.png"
              alt="Shops"
            />
            <img
              className="h-98"
              src="https://nsnoztviefjxvptztmnj.supabase.co/storage/v1/object/public/item_pics/background/image%2014.png"
              alt="Daily Task"
            />
          
        </Carousel>
      </div>  
      <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white shadow-sm sm:rounded-lg">
          <div className="p-6 bg-white border-b border-gray-200">
            <h1 className="text-5xl font-semibold text-gray-800 text-center">
              BISDAKIDS: SYSTEM STORE
            </h1>
          </div>
        </div>
        <div>
          <ViewGameStore checker={checker} setChecker={setChecker} />
        </div>   
      </div>   
    </div>
  );
}

export default GameStore;

