import React, {useState,useEffect} from "react"
import ViewGameStore from "../components/gameStoreComponents/ViewGameStore"

function GameStore(){
    const [checker, setChecker] = useState(false)
    return ( 
          <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div className="p-6 bg-white border-b border-gray-200">
                <h1 className="text-3xl font-semibold text-gray-800">
                  BISDAKIDS: SYSTEM STORE
                </h1>
                <ViewGameStore checker={checker} setChecker={setChecker} />
              </div>
            </div>
          </div>   
      )
}

export default GameStore    