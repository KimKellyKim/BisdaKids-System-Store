import React, { useState, useEffect } from "react"
import { supabase } from '../../supabase-config'
import Loading from "../Loading"

import { AiOutlineCloseCircle } from 'react-icons/ai'
import Box from '@mui/material/Box'
import Button from '@mui/material/Button'
import Typography from '@mui/material/Typography'
import Modal from '@mui/material/Modal'

const style = {
  position: 'absolute',
  top: '50%',
  left: '50%',
  transform: 'translate(-50%, -50%)',
  width: 400,
  bgcolor: 'white',
  border: '2px solid #000',
  boxShadow: 24,
  p: 4,
};

function ViewGameStore({ checker, setChecker }) {
  const [loading, setLoading] = useState(false)
  const [gameStoreData, setGameStoreData] = useState([])
  const [itemNames, setItemNames] = useState({})
  const [open, setOpen] = useState(false)
  const [selectedItemData, setSelectedItemData] = useState(null)

  useEffect(() => {
    fetchGameStore()
    fetchItemNames()
  }, [checker])

  const fetchGameStore = async () => {
    setLoading(true)
    const { data, error } = await supabase
      .from('system_store')
      .select('*')

    if (data) {
      setGameStoreData(data)
    }
    error && console.error(error)
    setLoading(false)
  }

  const fetchItemNames = async () => {
    const { data, error } = await supabase
      .from('items')
      .select('item_id, item_name')

    if (data) {
      const itemNamesMap = {}
      data.forEach(item => { itemNamesMap[item.item_id] = item.item_name; })
      setItemNames(itemNamesMap)
    }
    error && console.error(error)
  }

  const handleOpen = (data) => {
    setSelectedItemData(data)
    setOpen(true)
  }

  const handleClose = () => {
    setSelectedItemData(null)
    setOpen(false)
  }

  return (
    <div className="h-screen flex items-center justify-center">
      {loading ? (
        <Loading />
      ) : (
        <>
        <div className="w-4/6 max-w-screen-xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
          {gameStoreData.map(data => (
            <a
              onClick={() => handleOpen(data)}
              key={data.id}
              className="container hover:shadow-xl hover:shadow-orange-200 cursor-pointer rounded-lg overflow-hidden transition-transform transform hover:scale-105"
            >
              <img
                className="w-full h-48 object-cover"
                src="https://tecdn.b-cdn.net/img/new/standard/city/044.webp"
                alt="Skyscrapers"
              />
              <div className="p-4">
                <h5 className="text-xl font-semibold text-gray-900">
                  {itemNames[data.item_id] || 'Item Not Found'}
                </h5>
                <p className="text-gray-600">Php {data.price}</p>
                <p className="mt-2 text-gray-800">
                  Quantity: {data.offer_quantity}
                </p>
              </div>
            </a>
          ))}
        </div>
        </>
      )}
      <Modal
        open={open}
        onClose={handleClose}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
      >
        <Box sx={style}>
          <button
            onClick={handleClose}
            type="button"
            className="absolute top-4 right-5 text-3xl p-1 rounded-full hover:bg-gray-400 duration-150"
          >
            <AiOutlineCloseCircle />
          </button>
          <Typography id="modal-modal-title">
            <h1 className="text-2xl font-bold text-center text-green-500">
              Purchase
            </h1>
          </Typography>
          <Typography id="modal-modal-description" sx={{ mt: 2 }}>
            <div className="py-2">
              <div>
                {selectedItemData && (
                  <form className="flex flex-col p-4">
                    <div className="flex flex-col gap-4">
                      <label className="text-lg font-semibold" htmlFor="itemName">
                        Item Name: {itemNames[selectedItemData.item_id] || 'Item Not Found'}
                      </label>               
                      <label className="text-lg font-semibold" htmlFor="itemDesc">
                        Quantity: {selectedItemData.offer_quantity}
                      </label>
                      <label className="text-lg font-semibold" htmlFor="itemPrice">
                        Total Price: Php {selectedItemData.price}
                      </label>
                      <label htmlFor="bundleQuan" className='text-lg font-semibold'>Username:</label>
                        <input 
                            className='outline-none border-2 focus:border-gray-400 rounded-md text-center p-1' 
                        type="text" />
                        <div className="items-center ">
                            <Button variant='contained'>BUY</Button>
                        </div>     
                    </div>             
                  </form>
                )}
              </div>
            </div>
          </Typography>
        </Box>
      </Modal>
    </div>
  );
}

export default ViewGameStore;
