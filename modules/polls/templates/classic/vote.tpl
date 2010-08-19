<!--

**********************
* vote.tpl           *
* (c) nabocorp, 2002 *
**********************

Here are the tags valid here:

{SURVEY_ID}: id of the current survey
{SURVEY_TITLE}: title of the current survey
{SURVEY_URL}: url of the current survey (as defined in the database)

{QUESTION_ID}: id of the current question
{QUESTION_TEXT}: text of the current question
{QUESTION_SUBMIT}: image to validate the vote to the question

{ANSWER_ID}: id of the current answer
{ANSWER_RADIO}: radio button to vote for the current answer
{ANSWER_TEXT}: text of the current answer

-->

<p align="center">
<table width=450>
  <tr>
    <td colspan=2>
      <table cellspacing=0>
        <tr>
          <td bgcolor="gray" width=5></td>
          <td bgcolor="gray" valign="top"><font color="white" size="-1"><b>{QUESTION_ID}.</b></font></td>
          <td bgcolor="gray" width=5></td>
          <td bgcolor="gray" valign="top" width=450><font color="white" size="-1">{QUESTION_TEXT}</font></td>
        </tr>
      </table>
    </td>
  </tr>
  <!-- ANSWER START -->
  <tr>
    <td>
      <table>
        <tr>
          <td valign="top">{ANSWER_RADIO}</td>
          <td valign="top"><font size="-1">{ANSWER_TEXT}</font></td>
        </tr>
      </table>
    </td>
  </tr>
  <!-- ANSWER END -->
  <tr>
    <td align="center">&nbsp;<br>{QUESTION_SUBMIT}</td>
  </tr>
</table>
</p>