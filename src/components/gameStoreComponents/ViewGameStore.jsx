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
    overflowY:'auto',
    maxHeight:'90vh'
  }

  function ViewGameStore(checker) {
    const [loading, setLoading] = useState(false)
    const [gameStoreData, setGameStoreData] = useState([])
    const [itemNames, setItemNames] = useState({})
    const [open, setOpen] = useState(false)
    const [selectedItemData, setSelectedItemData] = useState(null)
    const [username, setUsername] = useState('')
    const [password,setPassword] = useState('')
    const [errorModal, setErrorModal] = useState(false)
    const [errorText, setErrorText] = useState('')
    const [successModal, setSuccessModal] = useState(false)
    const [successText, setSuccessText] = useState('')
    const [showPaymentModal, setShowPaymentModal] = useState(false)
    //const CDNURL = "https://nsnoztviefjxvptztmnj.supabase.co/storage/v1/object/public/item_pics/items";

    useEffect(() => {
      fetchGameStore()
      fetchItemNames()
    }, [checker])

    const fetchGameStore = async () => {
      setLoading(true)
      try {
        const { data, error } = await supabase
          .from('system_store')
          .select('*')

        if (error) {
          throw error
        }

        const gameStoreDataWithImages = await Promise.all(
          data.map(async (storeData) => {
            const itemInfo = await supabase
              .from('items')
              .select('item_image_url')
              .eq('item_id', storeData.item_id)
              .single()

            if (itemInfo.error) {
              throw itemInfo.error
            }

            const imageUrl = `${itemInfo.data.item_image_url}` // Construct the image URL
            
            return {
              ...storeData,
              item_image_url: imageUrl,
            }
          }))
        setGameStoreData(gameStoreDataWithImages)
        setLoading(false)
      } catch (error) {
        // Handle and log the error
        console.error('Error fetching data:', error)
        setErrorText('Failed to fetch game store data. Please try again later.')
        setErrorModal(true)
      }
    };

    const fetchItemNames = async () => {
      const { data, error } = await supabase
        .from('items')
        .select('item_id, item_name')

      if (data) {
        const itemNamesMap = {}
        data.forEach(item => {
          itemNamesMap[item.item_id] = item.item_name
        })
        console.log('Item Names:', itemNamesMap); 

        setItemNames(itemNamesMap)
      } else {
        setErrorText('Failed to fetch item names. Please check your internet connection and try again later.')
        setErrorModal(true)
      }
      error && console.error(error)
    }

    const handleOpen = (data) => {
      console.log('Item Data:', data)
      setSelectedItemData(data)
      setOpen(true)
    }

    const handleClose = () => {
      setSelectedItemData(null)
      setOpen(false)
    }

    // Function to fetch the user_id based on the entered username
    const fetchUserIdByUsername = async (username) => {
      const { data, error } = await supabase
        .from('user_account')
        .select('user_id')
        .eq('user_name', username)
        .single()

      if (data) {
        console.error("Success")
        return data.user_id
      } else {
        setErrorText("Username not found. Please try again")
        setErrorModal(true)
        console.error("Username not found")
        return null
      }
    }
    
    const handleBuy = async () => {
      if (selectedItemData && username && password) {
        const user_id = await fetchUserIdByUsername(username);
    
        if (user_id !== null) {
          // Check username and password
          const { data: user } = await supabase
            .from('user_account')
            .select('user_id')
            .eq('user_name', username)
            .eq('user_password', password)
            .single();
    
          if (user) {
            // Proceed to payment
            const store_offer_id = selectedItemData.id;
    
            if (store_offer_id !== null) {
              const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'http://localhost/BisdaKids-System-Store/backend/index.php';
    
            // Add hidden input fields for the data you want to pass
            const usernameField = document.createElement('input');
            usernameField.type = 'hidden';
            usernameField.name = 'username';
            usernameField.value = username;
            form.appendChild(usernameField);
    
            const itemDataField = document.createElement('input');
            itemDataField.type = 'hidden';
            itemDataField.name = 'item_data';
            itemDataField.value = JSON.stringify(selectedItemData);
            form.appendChild(itemDataField);

            const itemNameField = document.createElement('input');
            itemNameField.type = 'hidden';
            itemNameField.name = 'itemName';
            itemNameField.value = itemNames[selectedItemData.item_id] || 'Item Not Found'; // Make sure this line is correct
            form.appendChild(itemNameField);

            /* const itemQuantityField = document.createElement('input');
            itemQuantityField.type = 'hidden';
            itemQuantityField.name = 'quantity';
            itemQuantityField.value = JSON.stringify(selectedItemData);
            form.appendChild(itemQuantityField);
    
            const itemPriceField = document.createElement('input');
            itemPriceField.type = 'hidden';
            itemPriceField.name = 'price';
            itemPriceField.value = JSON.stringify(selectedItemData);
            form.appendChild(itemPriceField) */
            // Add other fields as needed
    
            document.body.appendChild(form);
            form.submit();
            } else {
              setErrorText('Store offer not found. Please try again later.');
              setErrorModal(true);
              console.error('Store offer not found');
            }
          } else {
            setErrorText('Invalid username or password. Please try again.');
            setErrorModal(true);
            console.error('Invalid username or password');
          }
        }
      } else {
        setErrorText('No username or password added. Please try again.');
        setErrorModal(true);
      }
      setOpen(false);
    };

    return (
      <div className="flex items-center justify-center">
        {loading ? (
          <Loading />
        ) : (     
          <div className="w-4/6 max-w-screen-xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 items-center">
          {gameStoreData.map((data, index) => (
            <a
              onClick={() => handleOpen(data)}
              key={index} 
              className="container bg-teal-100 hover:shadow-xl hover:shadow-orange-00 cursor-pointer rounded-lg overflow-hidden transition-transform transform hover:scale-105 flex flex-col items-center p-4 m-3"
            >
            <p className="hidden">{data.store_offer_id}</p>
              <div className="h-24 w-max flex items-center justify-center">
                <img
                  className="max-h-full"
                  src={data.item_image_url}
                  alt="images"
                />
              </div>
              <div className="p-4">
                <h5 className="text-3xl font-semibold text-yellow-500 capitalize">
                  {itemNames[data.item_id] || 'Item Not Found'}
                </h5>
              </div>
              <div className="p-4">
                <p className="text-2xl text-blue-900 font-medium">
                  Php {data.price}
                </p>
                <p className="text-gray-600">Quantity: {data.offer_quantity}</p>
              </div>
            </a>
          ))}
        </div>  
        )}
        <Modal
  open={open}
  onClose={handleClose}
  aria-labelledby="modal-modal-title"
  aria-describedby="modal-modal-description"
>
  <Box sx={style} className="p-6 bg-white rounded-md max-w-md mx-auto">
    <button
      onClick={handleClose}
      type="button"
      className="absolute top-4 right-5 text-3xl p-1 rounded-full hover:bg-gray-400 duration-150"
    >
      <AiOutlineCloseCircle />
    </button>
    <Typography id="modal-modal-title">
      <div className="text-2xl font-bold text-center text-green-500">
        Purchase
      </div>
    </Typography>
    <Typography id="modal-modal-description" sx={{ mt: 2 }}>
      <div className="py-2">
        {selectedItemData && (
          <form
            id="dataForm"
            className="flex flex-col p-4"
            method="POST"
            action="http://localhost/BisdaKids-System-Store/backend/index.php"
          >
            <div className="flex flex-column gap-4">
              <img
                name="image"
                src={selectedItemData.item_image_url}
                alt="Item"
                className="w-30 h-20 object-contain mx-auto"
              />
              {/* store id */}
              <input
                  type="hidden"
                  name="store_offer_id"
                  value={selectedItemData.store_offer_id || 'Item Not Found'}
                  readOnly
                  className="p-1"
                />
              <label className="text-lg font-semibold" htmlFor="itemName">
                Item Name
                <input
                  type="text"
                  name="itemName"
                  value={itemNames[selectedItemData.item_id] || 'Item Not Found'}
                  readOnly
                  className="border-2 rounded-md p-1 text-center"
                />
              </label>
              <label className="text-lg font-semibold" htmlFor="quantity">
                Quantity
                <input
                  type="text"
                  name="quantity"
                  value={selectedItemData.offer_quantity}
                  readOnly
                  className="border-2 rounded-md p-1 text-center"
                />
              </label>
              <label className="text-lg font-semibold" htmlFor="itemPrice">
                Total Price
                <input
                  name="price"
                  type="text"
                  value={`Php ${selectedItemData.price}`}
                  readOnly
                  className="border-2 rounded-md p-1 text-center"
                />
              </label>
              <label htmlFor="bundleQuan" className="text-lg font-semibold">
                Username:
              </label>
              <input
                className="outline-none border-2 focus:border-gray-400 rounded-md text-center p-1"
                type="text"
                name="username"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
              />
              <label htmlFor="password" className="text-lg font-semibold">
                Password:
              </label>
              <input
                className="outline-none border-2 focus:border-gray-400 rounded-md text-center p-1"
                type="password"
                name="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />

              <Button
                variant="contained"
                color="primary"
                onClick={handleBuy}
                className="mt-4"
              >
                PROCEED TO GCASH PAYMENT
              </Button>
            </div>
          </form>
        )}
      </div>
    </Typography>
  </Box>
</Modal>

        {errorModal && (
          <div className="fixed top-0 left-0 p-5 w-full h-screen flex justify-center items-center bg-gray-600 bg-opacity-50 z-40">
            <div className="relative flex flex-col items-center gap-5 p-5 bg-white shadow-2xl rounded-md">
              <h1 className="text-4xl font-bold text-red-500">{errorText}</h1>
              <button
                className="absolute top-2 right-2 p-1 hover-bg-red-500 rounded-full duration-150"
                type="button"
                onClick={() => setErrorModal(false)}
              >
                <p className="text-4xl">
                  <AiOutlineCloseCircle />
                </p>
              </button>
            </div>
          </div>
        )}
        {successModal && (
          <div className="fixed top-0 left-0 p-5 w-full h-screen flex justify-center items-center bg-gray-600 bg-opacity-50 z-40">
            <div className="flex flex-col items-center gap-5 p-5 bg-white shadow-2xl rounded-md">
              <h1 className="text-4xl font-bold text-green-500">{successText}</h1>
              <button
                className="p-1 hover-bg-red-500 rounded-full duration-150"
                type="button"
                onClick={() => setSuccessModal(false)}
              >
                <p className="text-4xl">
                  <AiOutlineCloseCircle />
                </p>
              </button>
            </div>
          </div>
        )}
      </div>
    );
  }

  export default ViewGameStore;
