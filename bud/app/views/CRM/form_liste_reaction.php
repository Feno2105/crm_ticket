<div>
    <h1>Add action</h1>
    <form action="" method="post">
        <div>
            <label for="name">Description</label>
            <textarea name="name" id="name" placeholder="Your description" required>

            </textarea>
        </div>
        <div>
            <label for="type_reaction">Type reaction</label>
            <select name="type_reaction" id="type_reaction" required>
                <option value="positive">positive</option>
                <option value="negative">negative</option>
                <option value="neutre">neutre</option>
            </select>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>