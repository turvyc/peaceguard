//
//  ReportViewController.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao, Robert Sanchez
//
//  Copyright (c) 2013 Number 123 Developer's Group
//

#import "ReportViewController.h"
#import "OverviewController.h"

@interface ReportViewController ()

@end

@implementation ReportViewController

@synthesize thePickerView;
@synthesize incidentSelection, severitySelection;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}


- (BOOL)textFieldShouldReturn:(UITextField *)textField {
    [textField resignFirstResponder];
    return YES;
}


- (void)viewDidLoad
{
    self.editLabel.text = @"Edit";
    
    self.hasReviewed = NO;
    self.reviewSubmitLabel.text = @"Review";
    self.reportEditLabel.text = @"Cancel";
    self.reviewWarning.hidden = YES;
    self.editButton.hidden = NO;
    self.editLabel.hidden = NO;
    self.Image.hidden = NO;
    
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *username = [defaults objectForKey:@"username"];
    self.username = username;
//    NSLog(self.username);
    
    self.pickerViewBlockerTop.alpha = 0.5;
    self.pickerViewBlockerBottom.alpha = 0.5;
    thePickerView.alpha = 1.0;
    thePickerView.hidden = YES;
    self.pickerViewBlockerTop.hidden = YES;
    self.pickerViewBlockerBottom.hidden = YES;

    
    thePickerView.showsSelectionIndicator = TRUE;
    thePickerView.delegate = self;
    self.location = [defaults objectForKey:@"currentLocation"];
    if(self.location != nil){
        self.locationDisplay.text = self.location;
    }
    
    NSDate *currDate = [NSDate date];
    NSDateFormatter *dateFormatter = [[NSDateFormatter alloc]init];
    [dateFormatter setDateFormat:@"dd.MM.YY HH:mm:ss"];
    NSString *dateString = [dateFormatter stringFromDate:currDate];
    self.date = dateString;

    
    
    //initializes text field display
    self.incidentData = @"vandalism";
    self.severityData = @"information";
    self.incidentLabel.text = self.incidentData;
    self.severityLabel.text = self.severityData;
    //should be initialized when pickerview pops up
    
    
    self.incidentSelection = [[NSArray alloc] initWithObjects: @"vandalism", @"graffiti", @"person", @"property", @"other", nil];
    self.severitySelection = [[NSArray alloc] initWithObjects: @"information", @"minor", @"serious",@"critical", nil];

#pragma mark BackgroundCode
    self.view.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"0.jpg"]];
#pragma mark -
    
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//*** PickerView code starts***
- (NSInteger)pickerView:(UIPickerView *)pickerView numberOfRowsInComponent:(NSInteger)component{
    
    if (component == 0){
        return [incidentSelection count];
    }
    else {
        return [severitySelection count];
    }
    
}

//number of columns/components of picker
-(NSInteger)numberOfComponentsInPickerView:(UIPickerView *)pickerView{
    
    return 2;
    
}

-(NSString *)pickerView:(UIPickerView *)pickerView titleForRow:(NSInteger)row forComponent:(NSInteger)component{
    
    if (component == 0){
        return [incidentSelection objectAtIndex:row];
        
    }
    else {
        return [severitySelection objectAtIndex:row];
        
    }
}

//returns value from pickerview
-(void)pickerView:(UIPickerView *)pickerView didSelectRow:(NSInteger)row inComponent:(NSInteger)component{
    
    if (component == 0){
        self.incidentData = [incidentSelection objectAtIndex:row];
        self.incidentLabel.text = self.incidentData;
    }
    
    else{
        self.severityData = [severitySelection objectAtIndex:row];
        self.severityLabel.text = self.severityData;
    }
    
    return;
    
}

//actually editButton
- (IBAction)incidentButtonPressed:(id)sender {
    if (thePickerView.hidden == YES){
        thePickerView.hidden = NO;
        self.pickerViewBlockerTop.hidden = NO;
        self.pickerViewBlockerBottom.hidden = NO;
        self.editLabel.text = @"Done";
    }
    else if (thePickerView.hidden == NO){
        thePickerView.hidden = YES;
        self.pickerViewBlockerTop.hidden = YES;
        self.pickerViewBlockerBottom.hidden = YES;
        self.editLabel.text = @"Edit";
    }
}

//*** PickerView code ends ***
- (IBAction)buttonToOverview:(id)sender {
    //get and set current time
    NSDate *currDate = [NSDate date];
    double theDate = [currDate timeIntervalSince1970];
    NSInteger *theTime =(NSInteger)theDate;
    //Set description
    self.descriptionOverview = self.description.text;
    
    if(self.hasReviewed == NO){ //first time pressing report/submit button
        self.hasReviewed = YES;
        self.reviewWarning.hidden = NO;
        self.Image.hidden = YES;
        self.editButton.hidden = YES;
        self.editLabel.hidden = YES;
        
        self.reviewSubmitLabel.text = @"Submit";
        self.description.enabled = FALSE;
        self.reportEditLabel.text = @"Edit";
    }
    else if(self.hasReviewed == YES){
        self.hasReviewed = NO;
        self.reviewWarning.hidden = YES;
        self.Image.hidden = NO;
        self.editButton.hidden = NO;
        self.editLabel.hidden = NO;
        
        self.reviewSubmitLabel.text = @"Review";
        self.description.enabled = TRUE;
        self.reportEditLabel.text = @"Cancel";
        //Send report to server
        self.reportManager = [[ReportDataController alloc] init];
        self.connectionManager = [[ConnectionDataController alloc] init];
        //If there is an image create a report with image
        if(!(CGSizeEqualToSize(self.imageView.image.size, CGSizeZero))){
            [self.reportManager makeReportWithType:self.incidentData severity:self.severityData location:self.location time:theTime image:UIImagePNGRepresentation(self.imageOverview) andDescription:self.descriptionOverview];
        }
        //Otherwise create a report with no image
        else{
            [self.reportManager makeReportWithType:self.incidentData severity:self.severityData location:self.location time:theTime andDescription:self.descriptionOverview];
        }
        NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
        NSString *incidentData = self.incidentData;
        NSString *serverityData = self.severityData;
        [defaults setObject:incidentData forKey:@"incidentData"];
        [defaults setObject:serverityData forKey:@"serverityData"];
        [defaults synchronize];
        NSLog(@"This is the username: %@", self.username);
        [self.connectionManager reportWithPostData:[self.reportManager getPOSTData:self.username]];
        
        //Return to previous page
        [self dismissViewControllerAnimated:YES completion:nil];
    }    
}

- (IBAction)reportEditPressed:(id)sender {
    if(self.hasReviewed == NO){ //just entered details
        [self dismissViewControllerAnimated:YES completion:nil];
    }
    else if(self.hasReviewed == YES){
        self.hasReviewed = NO;
        self.reviewWarning.hidden = YES;
        self.Image.hidden = NO;
        self.editButton.hidden = NO;
        self.editLabel.hidden = NO;
        
        self.reviewSubmitLabel.text = @"Review";
        self.description.enabled = TRUE;
        self.reportEditLabel.text = @"Cancel";
    }
}

- (BOOL) verify:(NSString *)description {
    if([description isEqualToString:@"Description"]) {
        return NO;
    }else{
        return YES;
    }
}

- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self.view endEditing:YES];
}

- (IBAction)ImageTaker:(id)sender {
    
    UIImagePickerController *picker = [[UIImagePickerController alloc] init];
    UIImagePickerControllerSourceType sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
    if([UIImagePickerController isSourceTypeAvailable:UIImagePickerControllerSourceTypeCamera]){
        sourceType = UIImagePickerControllerSourceTypeCamera;
    }
    [picker setSourceType:sourceType];
    picker.allowsEditing = NO;
    picker.delegate  = self;
    if(sourceType != UIImagePickerControllerSourceTypeCamera){
        UIAlertView *altert = [[UIAlertView alloc] initWithTitle:@"No Camera" message:@"Camera is not available" delegate:self cancelButtonTitle:@"ok" otherButtonTitles:nil];
        [altert show];
    }
    [self presentViewController:picker animated:YES completion:nil];
    
}
#pragma mark -
#pragma mark UIImagePickerControllerDelegate

- (void) imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info{
    
    [self dismissViewControllerAnimated:YES completion:nil];
    UIImage *image = info[UIImagePickerControllerOriginalImage];
    _imageView.image = image;

}

//
//-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
//
//    OverviewController *overviewController = (OverviewController *)segue.destinationViewController;
//    //sets value of variables from overview
//    overviewController.incidentData = self.incidentData;
//    overviewController.severityData = self.severityData;
//    overviewController.descriptionData = self.description.text;
//    overviewController.imageData = self.imageView.image;
//    overviewController.locationData = self.location;
//    
//}


@end
