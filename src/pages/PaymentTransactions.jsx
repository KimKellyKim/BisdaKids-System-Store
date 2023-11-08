import React, { useState } from 'react'

function PaymentTransactions({ itemData, username, itemNames, onPurchaseSuccess }) {
  const [mobile, setMobile] = useState('')
  const [email, setEmail] = useState('')
  const [paymentStatus, setPaymentStatus] = useState(null)

  const { item_id, item_image_url, offer_quantity, price } = itemData
  const itemName = itemNames[item_id] || 'Item Not Found'

  const handleFormSubmit = async (e) => {
    e.preventDefault()
  
    const formData = new FormData()
    formData.append('price', price)
    formData.append('quantity', offer_quantity)
    formData.append('itemName', itemName)
    formData.append('username', username)
    formData.append('mobile', mobile)
    formData.append('email', email)
  
    try {
      const response = await fetch('/backend/paymongo.php', {
        method: 'post',
        body: formData
        })
        .then(res => res.json())
        .then(data => console.log(data))
  
      if (response.ok) {
        if (res.success) {
          console.log('Payment successful')// Log that the payment was successful
          setPaymentStatus('success')
          onPurchaseSuccess()// Notify the parent component of a successful purchase
        } else {
          console.log('Payment failed')// Log that the payment failed
          setPaymentStatus('failure')
        }
      } else {
        console.error('Payment request failed with HTTP status: ' + response.status)
        setPaymentStatus('failure')
      }
    } catch (error) {
      console.error('An error occurred:', error)
      setPaymentStatus('failure')
    }
  };
  

  return (
    <div className="container">
      <div className="row">
        <div className="col-md-12 order-md-1" style={{ maxHeight: '80vh', overflowY: 'auto' }}>
          <form className="needs-validation flex flex-col p-4" onSubmit={handleFormSubmit}>
            <div className="flex flex-col gap-4">
              <img
                src={item_image_url}
                alt="Item"
                className="w-30 h-20 object-contain"
              />
              <div>
                <label htmlFor="price">Price: </label>
                <input type="text" className="form-control" name="price" value={price} readOnly/>
              </div>
              <div>
                <label htmlFor="quantity">Quantity: </label>
                <input className="form-control" name="quantity" value={offer_quantity} readOnly/>
              </div>
              <div>
                <label htmlFor="itemName">Item Name: </label>
                <input className="form-control" name="itemName" value={itemName} readOnly/>
              </div>
              <div>
                <label htmlFor="username">Username: </label>
                <input className="form-control" name="username" value={username} readOnly/>
              </div>
              <div className="mb-3">
                <label htmlFor="mobile">Mobile</label>
                <input
                  type="tel"
                  className="form-control"
                  name="mobile"
                  value={mobile}
                  onChange={(e) => setMobile(e.target.value)}
                  required
                />
                <div className="invalid-feedback">
                  Please enter a valid mobile number for shipping updates.
                </div>
              </div>
              <div className="mb-3">
                <label htmlFor="email">Email</label>
                <input
                  type="email"
                  className="form-control"
                  name="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                />
                <div className="invalid-feedback">
                  Please enter a valid email address for shipping updates.
                </div>
              </div>
            </div>
            <hr className="mb-4" />
            <button className="btn btn-primary btn-lg btn-block" type="submit">
              Continue to checkout
            </button>
          </form>
        </div>
      </div>
      {paymentStatus === 'success' && (
        <div className="alert alert-success">
          Payment was successful!
        </div>
      )}

      {paymentStatus === 'failure' && (
        <div className="alert alert-danger">
          Payment failed. Please try again.
        </div>
      )}
    </div>
  );
}

export default PaymentTransactions
