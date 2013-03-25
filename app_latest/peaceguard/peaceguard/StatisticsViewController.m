//
//  StatisticsViewController.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao, Robert Sanchez
//
//  Copyright (c) 2013 Number 13 Developer's Group
//

#import "StatisticsViewController.h"

@interface StatisticsViewController ()

@end

@implementation StatisticsViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *username = [defaults objectForKey:@"username"];
    self.username = username;
    
    //Setup Picker View
    self.statDurationPickerview.showsSelectionIndicator = TRUE;
    self.statDurationPickerview.delegate = self;
    self.durationData = @"last day";
    self.durationSelection = [[NSArray alloc] initWithObjects:@"last day", @"last month", @"last year", @"total", nil];
    
//    NSLog(self.username);
    [self updateStatsFor:@"lastDay"];
    //self.totalPatrolsField.text = [statsDictionary objectForKey:@"total"];

    
#pragma mark BackgroundCode
    self.view.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"0.jpg"]];
#pragma mark -
    

}

- (NSInteger)pickerView:(UIPickerView *)pickerView numberOfRowsInComponent:(NSInteger)component{
    
    return [self.durationSelection count];
    
}

//number of columns/components of picker
-(NSInteger)numberOfComponentsInPickerView:(UIPickerView *)pickerView{
    
    return 1;
    
}

-(NSString *)pickerView:(UIPickerView *)pickerView titleForRow:(NSInteger)row forComponent:(NSInteger)component{
    
    return [self.durationSelection objectAtIndex:row];
    
}

//returns value from pickerview
-(void)pickerView:(UIPickerView *)pickerView didSelectRow:(NSInteger)row inComponent:(NSInteger)component{
    
    self.durationData = [self.durationSelection objectAtIndex:row];
    
    NSString *timePeriod;
    if([self.durationData isEqualToString:@"last day"]){
        timePeriod = @"lastDay";
    }
    else if ([self.durationData isEqualToString:@"last month"]){
        timePeriod = @"lastMonth";
    }
    else if ([self.durationData isEqualToString:@"last year"]){
        timePeriod = @"yearToDate";
    }
    else if ([self.durationData isEqualToString:@"total"]){
        timePeriod = @"allTime";
    }
    [self updateStatsFor:timePeriod];
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}
        
- (void) updateStatsFor: (NSString *)timePeriod{
    self.connectionManager = [[ConnectionDataController alloc] init];
    NSDictionary *statsDictionary = [self.connectionManager getStatistics:self.username andTimePeriod:timePeriod];
    self.totalPatrolsField.text = [[statsDictionary objectForKey:@"total"] objectForKey:@"patrol"];
    self.totalDistanceField.text = [NSString stringWithFormat:@"%@m",[[statsDictionary objectForKey:@"total"] objectForKey:@"distance"]];
    NSLog(@"distance is :%@",self.totalDistanceField.text);
    self.numberOfIncidentsField.text = [[statsDictionary objectForKey:@"total"] objectForKey:@"report"];
    double timeString = [[[statsDictionary objectForKey:@"total"] objectForKey:@"time"] doubleValue]/60;
    self.totalTimeField.text = [NSString stringWithFormat:@"%.01fmin",timeString];
}

- (IBAction)statToBadge:(id)sender {
    [self performSegueWithIdentifier:@"statToBadge" sender:self];
}
@end
